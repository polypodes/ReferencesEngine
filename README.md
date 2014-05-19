# References Engine
## Summary

References Engine is a Symfony2-based References Books Generator.  
It purposes is to give our salesforce unicorns a way to generate neat PDFs of our best references, to be attached to their call for tender / competing offers bids. 

MIT licensed by [Les Polypodes](http://www.lespolypodes.com) (Nantes, France)

## Install

### Configure Vhost & domain

Use / adapt the `./doc/apache2.vhost.conf` file,
then add this line to your `/etc/hosts` file:

```
127.0.0.1   references
```

### Run install commands

```bash
git clone https://github.com/polypodes/ReferencesEngine.git references
cd references
make
make install
```

In short,

* `make` command run composer, then add required assets (assets & upload dirs, etc.)
* `make install` command creates db, schema, website, routes & snapshots

Have a look at the Makefile to check all the `make` available commands

### Create a super-admin

```bash
php app/console fos:user:create admin tech@lespolypodes.com --super-admin
```

password: lol (to match with the behat tests)

## Test it

Create and customize your test environment variables:

```bash
mv behat.yml.dist behat.yml
[open editor] behat.yml
```

To check your scenarii syntax:

```bash
bin/behat --story-syntax --lang fr
```

To check the available Behat tips:
```bash
bin/behat -dl --lang=fr
```

To test your scenarii:

```bash
bin/behat --lang=fr "@ApplicationRefactorReferenceBundle"
```


## API

cURL usage:

```bash
curl --data "username=admin&password=lol" http://referencesengine:8080/api/tokens/creates.json
```
Get clean output and ready to use

```bash
./generateToken.sh username password
```

## Preview

Preview is not available, so here's a cat instead:

![](http://lorempixel.com/500/300/cats/)

##  Limits

We have no limits.

## Sonata bundles in use

* [Symfony2 v2.3 documentation](http://symfony.com/doc/2.3/book/installation.html)
* [Sonata Block](http://sonata-project.org/bundles/block/master/doc/reference/installation.html)
* [Sonata Admin](http://sonata-project.org/bundles/admin/master/doc/reference/installation.html)
* [Sonata User](http://sonata-project.org/bundles/user/master/doc/reference/installation.html)
* [Sonata Media](http://sonata-project.org/bundles/media/master/doc/reference/installation.html)
* [a Sonata CMS tutorial](http://www.coolcoyote.net/php-mysql/installation-du-cms-sonata-page)

Note that [Sonata Page](http://sonata-project.org/bundles/page/master/doc/reference/installation.html) is not part of this project for now.

## Support

* Contributing / debugging : use [issues](https://github.com/polypodes/ReferencesEngine/issues) or send a [pull requests](https://github.com/polypodes/ReferencesEngine/pulls)
* Implementation help: [tech@lespolypodes.com](mailto:tech@lespolypodes.com)
* Training, pricing plans, beers, investments, love, tartiflettes : [contact@lespolypodes.com](mailto:contact@lespolypodes.com)

