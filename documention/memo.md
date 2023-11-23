## ------------------ git flow ------------------------


```console
gitflow -h
```

```console
git flow init -d
```

git branch -avv

### ------------------ feature -------------------

git flow feature start <name>  (démarre une branche feature)

git flow feature publish <name> (si on veu la push)

git flow feature finish <name>  

 (termine la branche, ramène la branche dévelop et mergela feature et sup la feature)

### ------------------- release --------------------

git flow release start <name> (name = 1.0.0 par exemple ca prépare une livraison a la prod)

git flow release finish <name> (ca merge dans la master et se replace sur develop )

### --------------------- hotfix --------------------

git flow hotfix start <name> (nouvelle branche depuis main)

git flow hotfix finish <name> (merge dans la main)

## -----------------------------------------------------------




## !!!!!!!! bug du profiler avec wamp !!!!!!!!!

au cas ou

```console
composer r symfony/apache-pack
```


### webpack encore

```console
composer r symfony/webpack-encore-bundle
```

```console
npm install --force
```

### maj en temps réel sur le serveur symfony

```console
npm install @symfony/webpack-encore --save-dev
```

```console
npm run dev-server
```


### installer sass


```console
npm install sass-loader sass --save-dev
```

activer .enableSass dans la config webpack

### installer Bootstrap

```console
npm install bootstrap --save-dev
```

ilfaut l'importer maintenant ds le scss

@import "~bootstrap/scss/bootstrap";


### installer fileloader pour compiler les images avec webpack


npm install file-loader@^6.0.0 --save-dev


### easyadmin

php bin/console make:admin:dashboard


### créer user

créer un admin a la main

```console
symfony console security:hash-password
```


```console
symfony console make:admin:crud
```

!!!!!!! UserCrudController il faut hasher le mot de passe si crud depuis easyadmin des users
voir le code dans le UserCrudController

### VichUploader


composer require vich/uploader-bundle


vich_uploader:
    db_driver: orm

    mappings:
        movies:
            uri_prefix: /images/movies
            upload_destination: '%kernel.project_dir%/public/images/movies'
            namer: Vich\UploaderBundle\Naming\SmartUniqueNamer




   ### ajouter des paramètres dans la config

   services.yaml

   parameters:
       nom_du_param: valeur
   

   ds le controleur injecter:
    ParameterBagInterface $parameterBagInterface

    
            
   ### formater date en français dans twig



    ```console
    composer require twig/intl-extra
    ```

   ### reset password