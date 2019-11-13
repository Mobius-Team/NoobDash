# NoobDash
NoobDash is a basic PHP website that demonstrates how to implement features supported by Mobius.

This includes a basic Abuse Reports browser, and a basic RSA Settings page.

### Configuring NoobDash
In the includes directory you will find a config.php file. In that file you will need to enter credentials for the site to access your ROBUST database, as well as enter the URL for your website.

Here is an example configuration that strips .php from the URLs. Remember to change the ServerName!

<details>
  <summary>Apache2 Config Example</summary>
  
  ```
  <VirtualHost *:80>  
    DocumentRoot /var/www/html  
    ServerName dashboard.example.com  
    <Directory /var/www/html>  
      RewriteEngine On  
      RewriteCond %{REQUEST_FILENAME} !-d  
      RewriteCond %{REQUEST_FILENAME} !-f  
      RewriteRule ^([^/.]+?)(/.+)?$ $1.php$2 [L]  
      </Directory>  
  </VirtualHost>
  ```
</details>
