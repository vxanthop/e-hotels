[< e-hotels](index.md) / [src / views](views.md) / layouts

# Layouts

Layouts define the surroundings of the views and thus form the skeleton of the website's front-end. They may be either _full_ layouts or _partial_ layouts.

* [Full layouts](#full-layouts)
* [Partial layouts](#partial-layouts)

### Full layouts
Full layouts define the various themes a website may have. They usually include the boilerplate templates for HTML pages, the stylesheets or scripts that are to be loaded on each page and also the commands to include the necessary partials. Full layouts are stored in the `src/views/layouts/` directory. An example of a full layout is shown below:

```php
<!-- src/views/layouts/theme.php -->

<!DOCTYPE html>
<html>
<head>
    <title><?= $block['title'] ?> | My website</title>
    <link rel="stylesheet" type="text/css" href="public/css/main.css" />
</head>
<body>
    <?php require 'partials/navigation.php' ?>
    <main>
        <?= $block['content'] ?>
    </main>
    <?php require 'partials/footer.php' ?>
    <script src="public/js/main.js"></script>
    <script src="public/js/bootstrap.js"></script>
</body>
</html>
```
_Note: The `<?= $a ?>` syntax is short for `<?php echo $a ?>` in PHP._

#### Blocks
Blocks are placeholders for the attributes of a page, like the title, the description etc. There is also a special block, named `content` which is where the content of the view is loaded. Let's consider for example, a view with content `<h1>Hello world!</h1>` that uses the above layout. When the view is loaded, the `$block['content']` placeholder will be replaced with the `<h1>Hello world!</h1>` string.

Blocks other than `content` are defined inside a view as shown below:

```php
<?php
// src/views/hello.php
    $block['title'] = 'Hello';
?>

<h1>Hello world!</h1>
```

### Partial layouts
Partial layouts, or partials, are snippets that can be included in the full layouts to render some general components, such as the navigation menu, the sidebar, the footer etc. Partials are stored in the `src/views/layouts/partials/` directory. An example of a partial is shown below:

```html
<!-- src/views/layouts/partials/navigation.php -->
<ul>
    <li>
        <a href="/">Home</a>
    </li>
    <li>
        <a href="/about">About us</a>
    </li>
    <li>
        <a href="/contact">Contact</a>
    </li>
</ul>
```

Partials are included in the full layouts by using the PHP `require` command.