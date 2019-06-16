# GLcms 
A CMS written with the Yii Framework from scratch 


## Installation

Setup site in Laradock and hostname in `hosts` file

Install Composer Dependencies
```
composer -v i
```

Install the database

```
php protected/yiic.php migrate
```

### File Structure

* `assets`: Contains published resource files
* `css`: Contains CSS files
* `images`: Contains image files
* `themes`: Contains application themes
* `protected`: Contains protected application files

#### protected folder

* `commands`: Contains customized yiic commands
* `components`: Contains reusable user components
* `config`: Contains configuration files
* `controllers`: Contains controller class files
* `data`: Contains the sample database
* `extensions`: Contains third-party extensions
* `messages`: Contains translated messages
* `models`: Contains model class files
* `runtime`: Contains temporarily generated files
* `tests`: Contains test scripts
* `views`: Contains controller view and layout files
