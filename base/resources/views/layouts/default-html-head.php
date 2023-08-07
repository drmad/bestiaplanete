<!DOCTYPE html>
<html>
<head>
<base href="<?=$this->getWebRoot()?>" />
<title><?=$this->getTitle() ?? $this->project->module?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?=$this->renderMetaTags()?>
<?=$this->renderLinkTags()?>
<?=$this->renderScriptTags()?>
</head>