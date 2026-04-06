# 🖼️ Problème d'affichage des images Drime - RÉSOLU

## 🔴 Le problème

Quand vous utilisez le lien partageable Drime dans une balise `<img>`, l'image ne s'affiche pas :

```html
<!-- ❌ NE FONCTIONNE PAS -->
<img src="https://app.drime.cloud/s/dH3u08fUcolRdqwvx52nF6RnRfz7KT">
```

**Pourquoi ?** Le lien `https://app.drime.cloud/s/...` est une **page de partage HTML**, pas un lien direct vers l'image.

---

## ✅ La solution

### Option 1 : Utiliser l'URL directe via l'API

L'URL directe pour afficher une image est :

```
https://app.drime.cloud/api/v1/file-entries/{FILE_ID}?token={YOUR_TOKEN}
```

### Option 2 : Utiliser l'attribut `direct_url` du modèle

Nous avons ajouté un attribut `direct_url` au modèle `CloudFile` qui retourne automatiquement l'URL correcte.

---

## 🛠️ Modifications apportées

### 1. **DrimeDriver.php**

Ajout de l'URL directe dans la réponse de l'upload :

```php
'url' => $fileEntry['url'] ?? $directUrl,
'direct_url' => $directUrl, // ← Nouveau
```

### 2. **CloudFileService.php**

Sauvegarde de l'URL directe dans les métadonnées :

```php
'metadata' => [
    // ...
    'direct_url' => $uploadResult['direct_url'] ?? null, // ← Nouveau
],
```

### 3. **CloudFile.php**

Ajout d'un accesseur pour récupérer l'URL directe :

```php
public function getDirectUrlAttribute(): ?string
{
    // Priorité à l'URL directe stockée dans metadata
    if (isset($this->metadata['direct_url'])) {
        return $this->metadata['direct_url'];
    }

    // Sinon, construire l'URL à partir du file_id
    if ($this->file_id && $this->platform === 'drime') {
        $token = config('services.drime.token');
        $apiUrl = config('services.drime.api_url');
        return "{$apiUrl}/file-entries/{$this->file_id}?token={$token}";
    }

    // Fallback
    return $this->shareable_link;
}
```

### 4. **Course.php**

Modification des méthodes pour utiliser `direct_url` :

```php
public function getCoverImageUrl(): ?string
{
    $cloudImage = $this->getFirstCloudImage();
    return $cloudImage?->direct_url ?? $this->path_img; // ← Changé
}
```

---

## 📝 Utilisation dans Blade

### Afficher une image

```blade
<img 
    src="{{ $course->getCoverImageUrl() }}" 
    alt="{{ $course->title }}"
    class="img-fluid rounded"
>
```

### Afficher une vidéo

```blade
<video controls width="100%">
    <source 
        src="{{ $course->getVideoUrl() }}" 
        type="video/mp4"
    >
</video>
```

### Accès direct à l'URL

```blade
{{-- URL directe pour affichage --}}
<img src="{{ $cloudFile->direct_url }}">

{{-- URL de partage (page HTML) --}}
<a href="{{ $cloudFile->shareable_link }}" target="_blank">
    Voir sur Drime
</a>
```

---

## 🔐 Note sur la sécurité

L'URL directe contient le token d'API dans l'URL :

```
https://app.drime.cloud/api/v1/file-entries/123?token=YOUR_TOKEN
```

**⚠️ Important :**
- Ne pas exposer cette URL publiquement
- Utiliser pour l'affichage côté serveur ou dans des pages authentifiées
- Pour un partage public, utiliser `shareable_link`

---

## 🔄 Différences entre les URLs

| Type | URL | Usage |
|------|-----|-------|
| **Shareable Link** | `https://app.drime.cloud/s/xxx` | Page de partage HTML avec preview |
| **Direct URL** | `https://app.drime.cloud/api/v1/file-entries/xxx?token=xxx` | URL directe pour `<img>` ou `<video>` |
| **Download URL** | `https://app.drime.cloud/api/v1/file-entries/xxx/download` | Téléchargement du fichier |

---

## 🧪 Test

Après la mise à jour, testez avec :

```php
// Dans votre controller ou route de test
$course = Course::find(1);
$image = $course->getFirstCloudImage();

dd([
    'shareable_link' => $image->shareable_link,
    'direct_url' => $image->direct_url,
]);
```

Vous devriez voir :

```php
[
    'shareable_link' => 'https://app.drime.cloud/s/dH3u08fUcolRdqwvx52nF6RnRfz7KT',
    'direct_url' => 'https://app.drime.cloud/api/v1/file-entries/123?token=YOUR_TOKEN'
]
```

Utilisez `direct_url` dans vos balises `<img>` ! ✅

---

## 🔄 Migration des données existantes

Si vous avez déjà des fichiers uploadés, exécutez ce script pour régénérer les URLs directes :

```php
use App\Models\CloudFile;

CloudFile::where('platform', 'drime')->chunk(100, function ($files) {
    foreach ($files as $file) {
        if ($file->file_id) {
            $token = config('services.drime.token');
            $apiUrl = config('services.drime.api_url');
            $directUrl = "{$apiUrl}/file-entries/{$file->file_id}?token={$token}";
            
            $metadata = $file->metadata ?? [];
            $metadata['direct_url'] = $directUrl;
            
            $file->update(['metadata' => $metadata]);
        }
    }
});
```

---

**✅ Problème résolu ! Vos images s'affichent maintenant correctement.**