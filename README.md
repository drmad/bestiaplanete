# Vendimia Framework

[![Join the chat at https://gitter.im/vendimia](https://badges.gitter.im/vendimia/vendimia.svg)](https://gitter.im/vendimia)

**Vendimia** is a PHP framework for fast developing web applications using the MVC design pattern.

**WARNING**: Vendimia is in a **very-very-alpha** stage of development. Several parts are incomplete, and the API can change in any moment. For now, it's not suitable for production environments. Use it at your own risk.

# Requirements

* [PHP](https://www.php.net/releases/8.1/en.php) 8.1+ with `mbstring` module installed.
* [Composer](https://getcomposer.org/)

# Quickstart

* Create a new project using [composer](https://getcomposer.org/):

```
composer create-project vendimia/project my_project
```

Where `my_project` is the name of the directory where your new project will be created.

* Launch a development server:

```
cd my_project
./vendimia server
```

Point your web browser to http://localhost:8888 and you're ready to go.

# Documentation

It's nonexistent :sweat_smile: I'm working on that, and it'll be published on (https://docs.vendimia.in).

You always can ask me question on the [Gitter chat](https://gitter.im/vendimia/vendimia).

# About the author

My name is [Oliver Etchebarne](http://drmad.org), from [Ica](https://en.wikipedia.org/wiki/Ica,_Peru), [Perú](https://en.wikipedia.org/wiki/Peru). I started (indirectly) coding this framework in the year 2000, building several libraries for access the database, html forms rendering and validating, etc.

*Circa* year 2012 I begun to find another language for creating web apps, disappointed about the *status quo* of PHP at that time. I tried Django and Rails, but neither really convinced me. Next year, I "discovered" that PHP was *[less ugly](https://drmad.org/blog/10-cosas-que-probablemente-no-sabias-de-php.html)*, so I gave it a new try, updating and integrating all my libraries (and creating new ones inspired on Django/Rails :grin:) in this framework base.

On 2014, I decided to polish all the libraries for publishing the framework as an Open Source project, and begun to close the gaps in the integration of every library, and gave its name "Vendimia". This year (2016) I gave it the last *overhauling* using the [PHP-FIG](http://www.php-fig.org/) guidelines, and updating the objects and classes for more loose-coupling between them, and implementing some other new coding paradigms.

On September 17, 2016, to celebrate the [Software Freedom Day](http://www.softwarefreedomday.org/), I finally published it to GitHub :smiley: .

On 2020, in the middle of COVID-19 lockdown, I decided to recreate the framework from scratch, as PHP 8.0 releasing date was close, and I love some of its new features 😋 Named arguments, attributes, constructor property promotion, and more 💙.

Hope to hear from you soon!
