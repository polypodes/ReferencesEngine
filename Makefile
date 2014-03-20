#
# Makefile
# ronan, 2014-03-05 10:40
#

all:
	@echo
	@curl http://getcomposer.org/installer | php
	@php composer.phar install --dev --optimize-autoloader
	@if [ ! -d "./web/uploads/media" ]; then mkdir -p ./web/uploads/media; fi;
	@chmod -R 0777 web/uploads
	@php app/console assets:install web --symlink

help:
	@echo
	@echo "Available tasks:"
	@echo
	@echo "\tTo install: make install"
	@echo "\tTo drop db: make dropDb"
	@echo "\tTo clear cache: make clear"
	@echo "\tTo run all tests: make tests"
	@echo

dropDb:
	@echo
	@echo "Drop database..."
	@php app/console doctrine:database:drop --force

createDb:
	@echo
	@echo "Create database..."
	@php app/console doctrine:database:create
	@php app/console doctrine:schema:update --force

createFr:
	@echo
	@echo "Creating a FRENCH default website http://references (local=fr)..."
	@php app/console sonata:page:create-site --default=true --locale="fr" --enabled=true --name="References" --relativePath="/" --host="references" --enabledFrom="now" --enabledTo="+10 years"

routes:
	@echo
	@echo "Creating routes & snapshots..."
	@php app/console sonata:page:update-core-routes --site=all
	@php app/console sonata:page:create-snapshots --site=all

clear:
	@echo
	@echo "Resetting cache..."
	@rm -rf app/cache/*

behat:
	bin/behat --lang=fr  "@ApplicationSonataAdminBundle"

done:
	@echo
	@echo "Please create a super-admin user (see README.md):"
	@echo
	@echo "\tex: 'php app/console fos:user:create admin tech@lespolypodes.com --super-admin'"
	@echo "\tpassword: lol (to match with the behat tests)"
	@echo

install: createDb createFr routes clear done

reinstall: dropDb install

tests: behat

# vim:ft=make
#
