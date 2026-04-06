# 🚀 Installation et Configuration de l'Intégration Drime Cloud

## 📋 Prérequis

- Laravel 10+
- PHP 8.1+
- Compte Drime Cloud avec API Token

---

## 🔧 ÉTAPE 1 : Configuration de l'environnement

### 1.1 Ajouter les variables dans `.env`

```env
DRIME_API_TOKEN=votre_token_bearer_ici
DRIME_API_URL=https://app.drime.cloud/api/v1
```

### 1.2 Configurer `config/services.php`

Ajouter cette configuration :

```php
'drime' => [
    'token' => env('DRIME_API_TOKEN'),
    'api_url' => env('DRIME_API_URL', 'https://app.drime.cloud/api/v1'),
],
```

---

## 📁 ÉTAPE 2 : Créer la structure des fichiers

### 2.1 Créer les dossiers nécessaires

```bash
mkdir -p app/Services/CloudStorage/Contracts
mkdir -p app/Services/CloudStorage/Drivers
mkdir -p app/Traits
```

### 2.2 Placer les fichiers

Placer les fichiers suivants dans les dossiers correspondants :

```
app/
├── Models/
│   └── CloudFile.php
├── Services/
│   ├── CloudFileService.php
│   └── CloudStorage/
│       ├── Contracts/
│       │   └── CloudStorageInterface.php
│       ├── Drivers/
│       │   └── DrimeDriver.php
│       └── CloudStorageManager.php
├── Providers/
│   └── CloudStorageServiceProvider.php
└── Traits/
    └── HasCloudFiles.php
```

---

## 🗄️ ÉTAPE 3 : Migration de la base de données

### 3.1 Créer la migration

```bash
php artisan make:migration create_cloud_files_table
```

### 3.2 Copier le contenu de la migration fournie

Copier le contenu du fichier `create_cloud_files_table.php` dans la migration créée.

### 3.3 Exécuter la migration

```bash
php artisan migrate
```

---

## ⚙️ ÉTAPE 4 : Enregistrer le Service Provider

### 4.1 Ajouter dans `config/app.php`

Dans le tableau `providers`, ajouter :

```php
'providers' => [
    // ...
    App\Providers\CloudStorageServiceProvider::class,
],
```

### 4.2 OU enregistrer automatiquement (Laravel 11+)

Dans `bootstrap/providers.php` :

```php
return [
    App\Providers\CloudStorageServiceProvider::class,
];
```

---

## 🎯 ÉTAPE 5 : Modifier le modèle Course

### 5.1 Ajouter le trait HasCloudFiles

```php
<?php

namespace App\Models;

use App\Traits\HasCloudFiles;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasCloudFiles; // ← Ajouter cette ligne

    // ... reste du code
}
```

---

## 📝 ÉTAPE 6 : Mettre à jour le Controller

### 6.1 Remplacer la fonction `backend_courses_store`

Remplacer votre fonction actuelle par celle fournie dans `CourseController_with_Drime.php`.

**Points importants :**

1. Injecter `CloudFileService` dans le constructeur
2. Uploader d'abord vers Drime
3. Ensuite mettre à jour le cours avec les liens

---

## 🧪 ÉTAPE 7 : Tester l'intégration

### 7.1 Test basique

```php
use App\Services\CloudFileService;

Route::get('/test-drime', function (CloudFileService $cloudFileService) {
    // Test de création de dossier
    $manager = app(\App\Services\CloudStorage\CloudStorageManager::class);
    $result = $manager->createFolder('test-courses');
    
    dd($result);
});
```

### 7.2 Test d'upload

Créer un cours avec une image et une vidéo via votre formulaire.

---

## 📖 UTILISATION

### Uploader un fichier

```php
use App\Services\CloudFileService;

public function uploadFile(Request $request, CloudFileService $cloudFileService)
{
    $cloudFile = $cloudFileService->uploadAndStore(
        file: $request->file('document'),
        fileableType: Course::class,
        fileableId: $course->id,
        fileType: 'document',
        platform: 'drime'
    );
    
    if ($cloudFile) {
        // Fichier uploadé avec succès
        $shareableLink = $cloudFile->shareable_link;
    }
}
```

### Récupérer les fichiers d'un cours

```php
// Avec le trait HasCloudFiles
$course = Course::find(1);

// Toutes les images
$images = $course->getCloudImages();

// Première vidéo
$video = $course->getFirstCloudVideo();

// Lien de la vidéo
$videoUrl = $video?->shareable_link;
```

### Afficher une vidéo dans Blade

```blade
@if($course->hasCloudFileType('video'))
    @php
        $video = $course->getFirstCloudVideo();
    @endphp
    
    <video controls width="100%">
        <source src="{{ $video->shareable_link }}" type="{{ $video->mime_type }}">
        Votre navigateur ne supporte pas la vidéo.
    </video>
@endif
```

### Afficher une image

```blade
@if($course->hasCloudFileType('image'))
    @php
        $image = $course->getFirstCloudImage();
    @endphp
    
    <img src="{{ $image->shareable_link }}" alt="{{ $course->title }}" class="img-fluid">
@endif
```

---

## 🔐 Sécurité

### Récupérer le token Drime

1. Se connecter sur https://app.drime.cloud
2. Aller dans les paramètres du compte
3. Section "API" ou "Developer"
4. Copier le Bearer Token
5. Le coller dans `.env` : `DRIME_API_TOKEN=...`

**⚠️ IMPORTANT :** Ne jamais commiter le fichier `.env` !

---

## 🎨 Ajouter d'autres plateformes (Mega, Google Drive, etc.)

### 1. Créer un nouveau driver

```php
<?php

namespace App\Services\CloudStorage\Drivers;

use App\Services\CloudStorage\Contracts\CloudStorageInterface;

class MegaDriver implements CloudStorageInterface
{
    // Implémenter les méthodes
}
```

### 2. Enregistrer le driver

Dans `CloudStorageManager.php` :

```php
public function __construct()
{
    $this->registerDriver('drime', new DrimeDriver());
    $this->registerDriver('mega', new MegaDriver()); // ← Ajouter
}
```

### 3. Utiliser

```php
$cloudFile = $cloudFileService->uploadAndStore(
    // ...
    platform: 'mega' // ← Changer la plateforme
);
```

---

## 🐛 Dépannage

### Erreur : "Drime API token not configured"

→ Vérifier que `DRIME_API_TOKEN` est bien défini dans `.env`

### Erreur : "Driver [drime] not found"

→ Vérifier que `CloudStorageServiceProvider` est enregistré dans `config/app.php`

### Fichier non uploadé

→ Vérifier les logs Laravel : `storage/logs/laravel.log`

---

## 📚 Ressources

- [Documentation Drime API](https://app.drime.cloud/swagger/yaml)
- [Documentation Laravel Storage](https://laravel.com/docs/filesystem)

---

## ✅ Checklist finale

- [ ] `.env` configuré avec le token Drime
- [ ] `config/services.php` mis à jour
- [ ] Migration `cloud_files` exécutée
- [ ] Tous les fichiers créés et placés correctement
- [ ] `CloudStorageServiceProvider` enregistré
- [ ] Trait `HasCloudFiles` ajouté au modèle `Course`
- [ ] Controller mis à jour
- [ ] Test d'upload réussi

---

**🎉 Félicitations ! Votre intégration Drime est maintenant opérationnelle !**