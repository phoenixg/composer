# 类库

本章节会告诉你如何制作可以通过 composer 来安装的自己的类库。

## 每个项目都是一个包（package）

一旦你的目录中有了一个 `composer.json` , 那么这个目录就是一个
包. 当你添加一个 `require` 到项目中去时, 你就在制作一个依赖于其他包的包. 
你的项目和类库之间的唯一区别是，你的项目是一个没有名称的包。

为了让这个包可被安装，你需要给他命名一个名称。添加一个 `name` 到 `composer.json` 中:

    {
        "name": "acme/hello-world",
        "require": {
            "monolog/monolog": "1.0.*"
        }
    }

这里例子里， 项目名称是 `acme/hello-world`, 而 `acme` 是 vendor 名称。
vendor 命名是强制需要提供的。

> **注意:** 如果你不知道该把什么当作 vendor 名称, 就用你的 GitHub
用户名， 这通常是一个好主意. 包名称是大小写不敏感的, 约定俗成的做法是
全部都小写，用短中杠（dashes）来分割单词。

## 平台包

Composer 有平台包， which are virtual packages for things that are
installed on the system but are not actually installable by composer. This
includes PHP itself, PHP extensions and some system libraries.

* `php` represents the PHP version of the user, allowing you to apply
   constraints, e.g. `>=5.4.0`. To require a 64bit version of php, you can
   require the `php-64bit` package.

* `ext-<name>` allows you to require PHP extensions (includes core
  extensions). Versioning can be quite inconsistent here, so it's often
  a good idea to just set the constraint to `*`.  An example of an extension
  package name is `ext-gd`.

* `lib-<name>` allows constraints to be made on versions of libraries used by
  PHP. The following are available: `curl`, `iconv`, `libxml`, `openssl`,
  `pcre`, `uuid`, `xsl`.

You can use `composer show --platform` to get a list of your locally available
platform packages.

## Specifying the version

You need to specify the package's version some way. When you publish your
package on Packagist, it is able to infer the version from the VCS (git, svn,
hg) information, so in that case you do not have to specify it, and it is
recommended not to. See [tags](#tags) and [branches](#branches) to see how
version numbers are extracted from these.

If you are creating packages by hand and really have to specify it explicitly,
you can just add a `version` field:

    {
        "version": "1.0.0"
    }

### Tags

For every tag that looks like a version, a package version of that tag will be
created. It should match 'X.Y.Z' or 'vX.Y.Z', with an optional suffix for RC,
beta, alpha or patch.

Here are a few examples of valid tag names:

    1.0.0
    v1.0.0
    1.10.5-RC1
    v4.4.4beta2
    v2.0.0-alpha
    v2.0.4-p1

> **Note:** If you specify an explicit version in `composer.json`, the tag name must match the specified version.

### Branches

For every branch, a package development version will be created. If the branch
name looks like a version, the version will be `{branchname}-dev`. For example
a branch `2.0` will get a version `2.0.x-dev` (the `.x` is added for technical
reasons, to make sure it is recognized as a branch, a `2.0.x` branch would also
be valid and be turned into `2.0.x-dev` as well. If the branch does not look
like a version, it will be `dev-{branchname}`. `master` results in a
`dev-master` version.

Here are some examples of version branch names:

    1.x
    1.0 (equals 1.0.x)
    1.1.x

> **Note:** When you install a dev version, it will install it from source.

### Aliases

It is possible alias branch names to versions. For example, you could alias
`dev-master` to `1.0.x-dev`, which would allow you to require `1.0.x-dev` in all
the packages.

See [Aliases](articles/aliases.md) for more information.

## Lock file

For your library you may commit the `composer.lock` file if you want to. This
can help your team to always test against the same dependency versions.
However, this lock file will not have any effect on other projects that depend
on it. It only has an effect on the main project.

If you do not want to commit the lock file and you are using git, add it to
the `.gitignore`.

## Publishing to a VCS

Once you have a vcs repository (version control system, e.g. git) containing a
`composer.json` file, your library is already composer-installable. In this
example we will publish the `acme/hello-world` library on GitHub under
`github.com/composer/hello-world`.

Now, To test installing the `acme/hello-world` package, we create a new
project locally. We will call it `acme/blog`. This blog will depend on
`acme/hello-world`, which in turn depends on `monolog/monolog`. We can
accomplish this by creating a new `blog` directory somewhere, containing a
`composer.json`:

    {
        "name": "acme/blog",
        "require": {
            "acme/hello-world": "dev-master"
        }
    }

The name is not needed in this case, since we don't want to publish the blog
as a library. It is added here to clarify which `composer.json` is being
described.

Now we need to tell the blog app where to find the `hello-world` dependency.
We do this by adding a package repository specification to the blog's
`composer.json`:

    {
        "name": "acme/blog",
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/composer/hello-world"
            }
        ],
        "require": {
            "acme/hello-world": "dev-master"
        }
    }

For more details on how package repositories work and what other types are
available, see [Repositories](05-repositories.md).

That's all. You can now install the dependencies by running composer's
`install` command!

**Recap:** Any git/svn/hg repository containing a `composer.json` can be added
to your project by specifying the package repository and declaring the
dependency in the `require` field.

## Publishing to packagist

Alright, so now you can publish packages. But specifying the vcs repository
every time is cumbersome. You don't want to force all your users to do that.

The other thing that you may have noticed is that we did not specify a package
repository for `monolog/monolog`. How did that work? The answer is packagist.

[Packagist](https://packagist.org/) is the main package repository for
composer, and it is enabled by default. Anything that is published on
packagist is available automatically through composer. Since monolog
[is on packagist](https://packagist.org/packages/monolog/monolog), we can depend
on it without having to specify any additional repositories.

If we wanted to share `hello-world` with the world, we would publish it on
packagist as well. Doing so is really easy.

You simply hit the big "Submit Package" button and sign up. Then you submit
the URL to your VCS repository, at which point packagist will start crawling
it. Once it is done, your package will be available to anyone.

&larr; [Basic usage](01-basic-usage.md) |  [Command-line interface](03-cli.md) &rarr;
