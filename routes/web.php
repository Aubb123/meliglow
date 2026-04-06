<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CloudFileController;
use App\Http\Controllers\CloudFolderController;
use App\Http\Controllers\CloudPlatformController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContinentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NotificationController; 
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    // Guest
    Route::middleware(['web.guest'])->group(function () {
        // Routes liée au système d'inscription et de connexion
        Route::get('/register', 'register')->name('register');
        Route::post('/register/store', 'register_store')->name('register.store');
        Route::get('/login', 'login')->name('login');
        Route::post('/login/store', 'login_store')->name('login.store');
        // Routes liée au système de mot de passe oublié 
        Route::get('/forgot/password', 'forgot_password')->middleware(['throttle:8,1'])->name('forgot.password');
        Route::post('/forgot/password/send/link', 'forgot_password_send_link')->middleware(['throttle:8,1'])->name('forgot.password.send.link');
        Route::get('/forgot/password/verify/otp/{token}', 'forgot_password_verify_otp')->middleware(['throttle:8,1'])->name('forgot.password.verify.otp');
        Route::post('/forgot/password/verify/otp/store/{token}', 'forgot_password_verify_otp_store')->middleware(['throttle:8,1'])->name('forgot.password.verify.otp.store');
        Route::get('/forgot/password/edit/new/password/{token}/{otp_code}', 'forgot_password_edit_new_password')->middleware(['throttle:8,1'])->name('forgot.password.edit.new.password');
        Route::put('/forgot/password/update/new/password/{token}', 'forgot_password_update_new_password')->middleware(['throttle:8,1'])->name('forgot.password.update.new.password');
    });

    // Auth
    Route::middleware(['web.auth'])->group(function () {
        // Routes de déconnexion
        Route::post('/logout', 'logout')->name('logout');
        // Routes liée au système d'activation de compte
        Route::get('/confirm/email/verifie/use_otp', 'email_verifie_use_otp')->name('email.verifie.use-otp'); // Choix de la méthode de vérification par defaut email
        Route::post('/confirm/email/resend', 'email_resend')->middleware(['throttle:8,1'])->name('email.resend'); // Renvoyer le mail de confirmation
        Route::put('/confirm/email/change', 'email_change')->middleware(['throttle:8,1'])->name('email.change'); // Changer l'email et renvoyer le mail de confirmation
        Route::post('/confirm/email/confirm', 'email_confirm')->middleware(['throttle:8,1'])->name('email.confirm'); // Confirmer l'email avec le code OTP
        // Route compte bloqué
        Route::get('/account/disabled', 'account_disabled')->name('account.disabled'); // Afficher la page de compte bloqué
    });
});

Route::middleware(['web.check.user.email'])->group(function () {
    
    // Route frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Route frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Route frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Route frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Route frontend ///////////////////////////////

        Route::controller(FrontendController::class)->group(function () {
            Route::get('/', 'frontend_index')->name('frontend.index');
            Route::get('/about', 'frontend_about')->name('frontend.about');
            Route::get('/contact', 'frontend_contact')->name('frontend.contact');
            Route::get('/privacy', 'frontend_privacy')->name('frontend.privacy');
            Route::get('/terms', 'frontend_terms')->name('frontend.terms');
        });
            
        Route::controller(ProductCategoryController::class)->group(function () {
            Route::get('/product-categories/{token}', 'frontend_product_categories_show')->name('frontend.product_categories.show');
        });
                
        Route::controller(ProductController::class)->group(function () {
            Route::get('/products/index', 'frontend_products_index')->name('frontend.products.index');
            Route::get('/products/show/{token}', 'frontend_products_show')->name('frontend.products.show');
            Route::get('/products/search', 'frontend_products_search')->name('frontend.products.search');
        });

        Route::controller(SubscribeController::class)->group(function () {
            Route::post('/subscribes/store', 'frontend_subscribe_store')->name('frontend.subscribe.store');
        });

        Route::controller(ContactController::class)->group(function () {
            Route::post('/contacts/store', 'frontend_contacts_store')->name('frontend.contacts.store');
        }); 

        Route::controller(BlogController::class)->group(function () {
            Route::get('/blogs', 'frontend_blogs_index')->name('frontend.blogs.index');
            });


    /// End Route frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// End Route frontend /////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// End Route frontend ///////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// End Route frontend ///////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// End Route frontend /////////////////////////// 


    // Route backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Route backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Route backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Route backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Route backend ///////////////////////////////

        // Réservé aux Admins, Développeurs et Modérateurs
        Route::middleware(['web.auth', 'web.check.role.user:1,2,3'])->group(function () {

            Route::controller(BackendController::class)->group(function () {
                Route::get('/backend/index', 'backend_index')->name('backend.index');
                Route::get('/backend/export-db', 'export')->name('backend.export.db');
            });

            // Start Route CloudPlatforms 
            Route::prefix('/dashboard/cloud-platforms')->group(function () {
                Route::controller(CloudPlatformController::class)->group(function () {
                    Route::get('/index', 'backend_cloud_platforms_index')->name('backend.cloud_platforms.index');
                    Route::get('/show/{token}', 'backend_cloud_platforms_show')->name('backend.cloud_platforms.show');
                    // ***
                    Route::get('/cloud-folders/{token}', 'backend_cloud_platforms_cloud_folders')->name('backend.cloud_platforms.cloud_folders');
                });
            });
            // End Route CloudPlatforms

            // Start Route CloudFolders
            Route::prefix('/dashboard/cloud-folders')->group(function () {
                Route::controller(CloudFolderController::class)->group(function () {
                    Route::get('/create/{cloudPlatformToken}', 'backend_cloud_folders_create')->name('backend.cloud_folders.create');
                    Route::post('/store/{cloudPlatformToken}', 'backend_cloud_folders_store')->name('backend.cloud_folders.store');
                    Route::get('/show/{token}', 'backend_cloud_folders_show')->name('backend.cloud_folders.show');
                    Route::delete('/destroy/{token}', 'backend_cloud_folders_destroy')->name('backend.cloud_folders.destroy');
                });
            });

            // Route CloudFiles
            Route::prefix('/dashboard/cloud-files')->group(function () {
                Route::controller(CloudFileController::class)->group(function () {
                    Route::post('/upload', 'backend_model_upload')->name('backend.cloud_files.upload');
                    Route::delete('/delete', 'backend_model_delete')->name('backend.cloud_files.delete');
                });
            });

            // Start Route roles 
            Route::prefix('/dashboard/roles')->group(function () {
                Route::controller(RoleController::class)->group(function () {
                    Route::get('/index', 'backend_roles_index')->name('backend.roles.index');
                    Route::get('/show/{token}', 'backend_roles_show')->name('backend.roles.show');
                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::get('/edit/{token}', 'backend_roles_edit')->name('backend.roles.edit');
                        Route::put('/update/{token}', 'backend_roles_update')->name('backend.roles.update');
                    });
                    // ...
                    Route::get('/users/{token}', 'backend_roles_users')->name('backend.roles.users');
                    // ...
                });
            });
            // End Route roles 

            // Start Route des continents
            Route::prefix('/dashboard/continents')->group(function () {
                Route::controller(ContinentController::class)->group(function () {
                    Route::get('/index', 'backend_continents_index')->name('backend.continents.index');
                    Route::get('/show/{token}', 'backend_continents_show')->name('backend.continents.show');
                    // Route::get('/create', 'backend_continents_create')->name('backend.continents.create');
                    // Route::post('/store', 'backend_continents_store')->name('backend.continents.store');
                    Route::get('/edit/{token}', 'backend_continents_edit')->name('backend.continents.edit');
                    Route::put('/update/{token}', 'backend_continents_update')->name('backend.continents.update');
                    // Route::delete('/destroy/{token}', 'backend_continents_destroy')->name('backend.continents.destroy');

                    // Autres
                    Route::get('/countries/{token}', 'backend_continents_countries')->name('backend.continents.countries');

                });
            }); 
            // End Route des organisations

            // Start Route des countries
            Route::prefix('/dashboard/countries')->group(function () {
                Route::controller(CountryController::class)->group(function () {
                    Route::get('/index', 'backend_countries_index')->name('backend.countries.index');
                    Route::get('/show/{token}', 'backend_countries_show')->name('backend.countries.show');
                    // Route::get('/create', 'backend_countries_create')->name('backend.countries.create');
                    // Route::post('/store', 'backend_countries_store')->name('backend.countries.store');
                    Route::get('/edit/{token}', 'backend_countries_edit')->name('backend.countries.edit');
                    Route::put('/update/{token}', 'backend_countries_update')->name('backend.countries.update');
                    // Route::delete('/destroy/{token}', 'backend_countries_destroy')->name('backend.countries.destroy');
                });
            }); 
            // End Route des countries

            // Start Route des users 
            Route::prefix('/dashboard/users')->group(function () {
                Route::controller(UserController::class)->group(function () {

                    Route::get('/index', 'backend_users_index')->name('backend.users.index');
                    Route::get('/show/{token}', 'backend_users_show')->name('backend.users.show');

                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::get('/create', 'backend_users_create')->name('backend.users.create');
                        Route::post('/store', 'backend_users_store')->name('backend.users.store');
                        Route::get('/edit/{token}', 'backend_users_edit')->name('backend.users.edit');
                        Route::put('/update/{token}', 'backend_users_update')->name('backend.users.update');
                        Route::delete('/destroy/{token}', 'backend_users_destroy')->name('backend.users.destroy');
                    });   

                    // ...
                    Route::get('/blogs/{token}', 'backend_users_blogs')->name('backend.users.blogs');
                    Route::get('/comments/{token}', 'backend_users_comments')->name('backend.users.comments');
                    // ...

                });
            }); 
            // End Route des users 

            // Start Route des categories 
            Route::prefix('/dashboard/categories')->group(function () {
                Route::controller(CategorieController::class)->group(function () {
                    Route::get('/index', 'backend_categories_index')->name('backend.categories.index');
                    Route::get('/create', 'backend_categories_create')->name('backend.categories.create');
                    Route::post('/store', 'backend_categories_store')->name('backend.categories.store');
                    Route::get('/show/{token}', 'backend_categories_show')->name('backend.categories.show');
                    Route::get('/edit/{token}', 'backend_categories_edit')->name('backend.categories.edit');
                    Route::put('/update/{token}', 'backend_categories_update')->name('backend.categories.update');
                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::delete('/destroy/{token}', 'backend_categories_destroy')->name('backend.categories.destroy');
                    });        
                    // ...
                    Route::get('/blogs/{token}', 'backend_categories_blogs')->name('backend.categories.blogs');
                    // ...
                });
            }); 
            // End Route des categories 

            // Start Route des tags 
            Route::prefix('/dashboard/tags')->group(function () {
                Route::controller(TagController::class)->group(function () {
                    Route::get('/index', 'backend_tags_index')->name('backend.tags.index');
                    Route::get('/create', 'backend_tags_create')->name('backend.tags.create');
                    Route::post('/store', 'backend_tags_store')->name('backend.tags.store');
                    Route::get('/show/{token}', 'backend_tags_show')->name('backend.tags.show');
                    Route::get('/edit/{token}', 'backend_tags_edit')->name('backend.tags.edit');
                    Route::put('/update/{token}', 'backend_tags_update')->name('backend.tags.update');
                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::delete('/destroy/{token}', 'backend_tags_destroy')->name('backend.tags.destroy');
                    });        
                    // ...
                    Route::get('/blogs/{token}', 'backend_tags_blogs')->name('backend.tags.blogs');
                    // ...
                });
            }); 
            // End Route tags 

            // Start Route des blogs 
            Route::prefix('/dashboard/blogs')->group(function () {
                Route::controller(BlogController::class)->group(function () {

                    Route::get('/index', 'backend_blogs_index')->name('backend.blogs.index');
                    Route::get('/show/{token}', 'backend_blogs_show')->name('backend.blogs.show');
                    
                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::get('/create', 'backend_blogs_create')->name('backend.blogs.create');
                        Route::post('/store', 'backend_blogs_store')->name('backend.blogs.store');
                        Route::get('/edit/{token}', 'backend_blogs_edit')->name('backend.blogs.edit');
                        Route::put('/update/{token}', 'backend_blogs_update')->name('backend.blogs.update');
                        Route::delete('/destroy/{token}', 'backend_blogs_destroy')->name('backend.blogs.destroy');
                    });  

                    // ...
                    Route::get('/comments/{token}', 'backend_blogs_comments')->name('backend.blogs.comments');
                    Route::get('/replies/{token}', 'backend_blogs_replies')->name('backend.blogs.replies');
                    // ...
                });
            }); 
            // End Route des blogs

            // Start Route des comments 
            Route::prefix('/dashboard/comments')->group(function () {
                Route::controller(CommentController::class)->group(function () {
                    Route::get('/index', 'backend_comments_index')->name('backend.comments.index');
                    Route::get('/show/{token}', 'backend_comments_show')->name('backend.comments.show');
                    Route::put('/update/{token}', 'backend_comments_update')->name('backend.comments.update');
                    //Réserver uniquement aux Admins, et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::delete('/destroy/{token}', 'backend_comments_destroy')->name('backend.comments.destroy');
                    });        
                    // ...
                    Route::get('/replies/{token}', 'backend_comments_replies')->name('backend.comments.replies');
                    // ...
                });
            }); 
            // End Route des comments

            // Start Route des Categories de products
            Route::prefix('/dashboard/product-categories')->group(function () {
                Route::controller(ProductCategoryController::class)->group(function () {
                    Route::get('/index', 'backend_product_categories_index')->name('backend.product_categories.index');
                    Route::get('/create', 'backend_product_categories_create')->name('backend.product_categories.create');
                    Route::post('/store', 'backend_product_categories_store')->name('backend.product_categories.store');
                    Route::get('/show/{token}', 'backend_product_categories_show')->name('backend.product_categories.show');
                    Route::get('/edit/{token}', 'backend_product_categories_edit')->name('backend.product_categories.edit');
                    Route::put('/update/{token}', 'backend_product_categories_update')->name('backend.product_categories.update');
                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::delete('/destroy/{token}', 'backend_product_categories_destroy')->name('backend.product_categories.destroy');
                    });        
                });
            }); 
            // End Route des Categories de products 

            // Start Route des products
            Route::prefix('/dashboard/products')->group(function () {
                Route::controller(ProductController::class)->group(function () {
                    Route::get('/index', 'backend_products_index')->name('backend.products.index');
                    Route::get('/show/{token}', 'backend_products_show')->name('backend.products.show');
                    //Réserver uniquement aux Admins et au Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::get('/create/{categorie_token}', 'backend_products_create')->name('backend.products.create');
                        Route::post('/store', 'backend_products_store')->name('backend.products.store');
                        Route::get('/edit/{token}', 'backend_products_edit')->name('backend.products.edit');
                        Route::put('/update/{token}', 'backend_products_update')->name('backend.products.update');
                        Route::delete('/destroy/{token}', 'backend_products_destroy')->name('backend.products.destroy');
                        Route::patch('/featured/{token}', 'backend_products_featured')->name('backend.products.featured');
                    });  
                });
            }); 
            // End Route des products

            // Start Route des subscribes 
            Route::prefix('/dashboard/subscribes')->group(function () {
                Route::controller(SubscribeController::class)->group(function () {
                    Route::get('/index', 'backend_subscribes_index')->name('backend.subscribes.index');
                    Route::get('/edit/{token}', 'backend_subscribes_edit')->name('backend.subscribes.edit');
                    Route::put('/update/{token}', 'backend_subscribes_update')->name('backend.subscribes.update');
                    //Réserver uniquement aux Admins et aux Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::delete('/destroy/{token}', 'backend_subscribes_destroy')->name('backend.subscribes.destroy');
                    });        
                });
            }); 
            // End Route des subscribes

            // Start Route des contacts 
            Route::prefix('/dashboard/contacts')->group(function () {
                Route::controller(ContactController::class)->group(function () {
                    Route::get('/index', 'backend_contacts_index')->name('backend.contacts.index');
                    Route::get('/show/{token}', 'backend_contacts_show')->name('backend.contacts.show');
                    //Réserver uniquement aux Admins et aux Développeurs
                    Route::middleware(['web.check.role.user:1,2'])->group(function () {
                        Route::delete('/destroy/{token}', 'backend_contacts_destroy')->name('backend.contacts.destroy');
                    });        
                });
            }); 
            // End Route des contacts

        });    

    /// End Route backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// End Route backend /////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// End Route backend ///////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// End Route backend ///////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// End Route backend /////////////////////////// 
});