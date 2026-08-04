# XOSHUI — servir le projet

Le framework n'a besoin de rien : deux fichiers statiques et du PHP. La seule chose à
configurer est ce qui **ne doit pas** être servi.

## Ce qui doit rester inaccessible

| Chemin | Pourquoi |
|---|---|
| `.git/` | tout l'historique est téléchargeable, y compris ce qui a été supprimé depuis |
| `.gitignore`, `.htaccess` | fichiers d'infrastructure |
| `config.local.php` | identifiants de base de données |
| `CLAUDE.md` | instructions de travail, pas une page |
| `layouts/_nav.php` | partiel inclus, jamais appelé directement |

`docs/` reste accessible : l'aide-mémoire est lié depuis l'interface.

## nginx

C'est le serveur utilisé par Laragon sur ce poste. **nginx ne lit pas les `.htaccess`** —
la configuration doit vivre dans le vhost.

```nginx
server {
    listen 80;
    server_name xoshui.test;
    root "D:/laragon/www/XOSHUI";
    index index.php index.html;

    # Pas de listing : un dossier sans index ne dévoile pas son contenu.
    autoindex off;

    # Fichiers cachés — .git en premier lieu. 404 plutôt que 403 :
    # un refus confirmerait la présence du fichier.
    location ~ /\.(?!well-known) { return 404; }

    # Fichiers de travail et partiels PHP.
    location ~ ^/(CLAUDE\.md|config\.local\.php)$ { return 404; }
    location ~ /_[^/]+\.php$                      { return 404; }

    location / { try_files $uri $uri/ /index.php$is_args$args; }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass php_upstream;
    }
}
```

Sous Laragon, le fichier `etc/nginx/sites-enabled/auto.XOSHUI.test.conf` est **régénéré**
à chaque démarrage. Pour que les modifications survivent, retirer le préfixe `auto.` —
Laragon cesse alors de le gérer.

## Apache

Le [.htaccess](../.htaccess) à la racine couvre les mêmes règles. Il n'a d'effet que si le
vhost autorise les surcharges :

```apache
<Directory "/var/www/xoshui">
    AllowOverride All
    Require all granted
</Directory>
```

## Vérifier

```bash
curl -o /dev/null -w '%{http_code}\n' http://xoshui.test/.git/HEAD   # attendu : 404
curl -o /dev/null -w '%{http_code}\n' http://xoshui.test/            # attendu : 200
php tools/lint.php                                                   # attendu : sortie 0
```
