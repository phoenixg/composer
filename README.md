Composer - PHP的依赖管理器
==========================

Composer 是一个跟踪本地项目和类库依赖的依赖管理器。

访问 [https://getcomposer.org/](https://getcomposer.org/) 以得到更多信息和文档。

[![Build Status](https://secure.travis-ci.org/composer/composer.png?branch=master)](http://travis-ci.org/composer/composer)

安装 / 使用
--------------------

1. 下载 [`composer.phar`](https://getcomposer.org/composer.phar) 该可执行包或使用安装器。

    ``` sh
    $ curl -sS https://getcomposer.org/installer | php
    ```


2. 创建一个 composer.json 文件来定义你的依赖关系。 注意，这个例子只是一个应用程序的小版本，不是为了发布为包自身。 如要创建类库/包，请阅读 [guidelines](https://packagist.org/about).

    ``` json
    {
        "require": {
            "monolog/monolog": ">=1.0.0"
        }
    }
    ```

3. 运行 Composer: `php composer.phar install`
4. 在这里浏览更多的包（packages ) [Packagist](https://packagist.org).

从源码安装
-----------

要运行测试，或开发 Composer 自身, 你必须使用源码而不是上面介绍的phar文件。

1. 运行 `git clone https://github.com/composer/composer.git`
2. 下载 [`composer.phar`](https://getcomposer.org/composer.phar) 可执行文件
3. 运行 Composer 来获取依赖: `cd composer && php ../composer.phar install`

现在你可以通过执行 `bin/composer` 脚本来运行 Composer : `php /path/to/composer/bin/composer`

Composer 全局安装(手动)
-------------------------

由于 Composer 是工作在当前目录下的，还可以把它安装在系统范围。

1. 改变目录 `cd /usr/local/bin`
2. 获取 Composer `curl -sS https://getcomposer.org/installer | php`
3. 让phar变为可执行 `chmod a+x composer.phar`
4. 切换到项目路径 `cd /path/to/my/project`
5. 使用 Composer 作为你通常使用的 `composer.phar install`
6. 可选地，你可以把 composer.phar 重命名为 composer 以使它更为方便

Composer 全局安装(via homebrew)
---------------------------------

Composer 是 homebrew-php 项目的一部分。

1. Tap the homebrew-php repository into your brew installation if you haven't done yet: `brew tap josegonzalez/homebrew-php`
2. Run `brew install josegonzalez/php/composer`.
3. Use Composer with the `composer` command.

Updating Composer
-----------------

Running `php composer.phar self-update` or equivalent will update a phar
install with the latest version.

Contributing
------------

All code contributions - including those of people having commit access -
must go through a pull request and approved by a core developer before being
merged. This is to ensure proper review of all the code.

Fork the project, create a feature branch, and send us a pull request.

To ensure a consistent code base, you should make sure the code follows
the [Coding Standards](http://symfony.com/doc/2.0/contributing/code/standards.html)
which we borrowed from Symfony.

If you would like to help take a look at the [list of issues](http://github.com/composer/composer/issues).

Community
---------

Mailing lists for [user support](http://groups.google.com/group/composer-users) and
[development](http://groups.google.com/group/composer-dev).

IRC channels are on irc.freenode.org: [#composer](irc://irc.freenode.org/composer)
for users and [#composer-dev](irc://irc.freenode.org/composer-dev) for development.

Stack Overflow has a growing collection of
[Composer related questions](http://stackoverflow.com/questions/tagged/composer-php).

Requirements
------------

PHP 5.3.2 or above (at least 5.3.4 recommended to avoid potential bugs)

Authors
-------

Nils Adermann - <naderman@naderman.de> - <http://twitter.com/naderman> - <http://www.naderman.de><br />
Jordi Boggiano - <j.boggiano@seld.be> - <http://twitter.com/seldaek> - <http://seld.be><br />

See also the list of [contributors](https://github.com/composer/composer/contributors) who participated in this project.

License
-------

Composer is licensed under the MIT License - see the LICENSE file for details

Acknowledgments
---------------

- This project's Solver started out as a PHP port of openSUSE's
  [Libzypp satsolver](http://en.opensuse.org/openSUSE:Libzypp_satsolver).
- This project uses hiddeninput.exe to prompt for passwords on windows, sources
  and details can be found on the [github page of the project](https://github.com/Seldaek/hidden-input).
