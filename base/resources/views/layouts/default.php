<?php

use Vendimia\ObjectManager\ObjectManager;
use Vendimia\Core\Csrf;

/**
 * Default layout.
 */

// base/resource/js/vendimia.js contains a few javascript helpers.
$this->addJs('vendimia');

// CSRF prevention token
$this->addMetaName('vendimia-token', ObjectManager::retrieve()->get(Csrf::Class));

// base/resource/views/layouts/default-html-head.php contains default DOCTYPE
// and HEAD tags, along with head tags like TITLE, SCRIPT, META, all accessed
// using the $this->add* methods.
$this->includeLayout('default-html-head');
?>
<body>
<?php
/**
 * This will render the view content at this point in the HTML.
 */
echo $this->insertContent();
?>
<footer style="font-family: sans-serif; position: fixed; bottom: 3px; right: 3px; font-size: 10px; color: #aaa; text-align: center; font-variant: small-caps">
Built with <a href="http://vendimia.in/" style="color: #888;" target="_blank">Vendimia Framework</a>
</footer>
</body>
</html>
