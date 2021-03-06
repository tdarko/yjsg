<?php
/**
 * @package   YJSimpleGrid Joomla! Template Framework
 * @author    Youjoomla.com
 * @websites  http://www.youjoomla.com, http://www.yjsimplegrid.com
 * @license - PHP files are licensed under  GNU/GPL V2
 * @license - CSS  - JS - IMAGE files  are Copyrighted material
 * @bound by Proprietary License of Youjoomla.com
*/
 // no direct access
defined('_JEXEC') or die('Restricted access'); 
$app 						= JFactory::getApplication();
$images 					= json_decode($this->item->images);
$yjsg_params 				= $app->getTemplate(true)->params;
$fp_controll_switch      	= $yjsg_params->get('fp_controll_switch');
$fp_chars_limit          	= $yjsg_params->get('fp_chars_limit');
$fp_after_text           	= $yjsg_params->get('fp_after_text');


$params 	= $this->item->params;
$canEdit	= $params->get('access-edit');




$edit_icon	= JHtml::_('icon.edit', $this->item, $params);
$email_icon = JHtml::_('icon.email', $this->item, $params);
$print_icon = JHtml::_('icon.print_popup', $this->item, $params);

// micro data
$article_nameMD 			= '';
$article_urlMD 				= '';
$article_genreMD 			= '';
$article_createdMD 			= '';
$article_modifiedMD 		= '';
$article_publishedMD 		= '';
$article_authorMD 			= '';
$article_interactionrMD 	= '';
$article_descriptionMD 		= '';
$article_imageMD 			= '';

if($params->get('yjsg_microdata_cat_enabeled') == 1){
	$article_nameMD 			= ' itemprop="name"';
	$article_urlMD 				= ' itemprop="url"';
	$article_genreMD 			= ' itemprop="genre"';
	$article_createdMD 			= ' itemprop="dateCreated"';
	$article_modifiedMD 		= ' itemprop="dateModified"';
	$article_publishedMD 		= ' itemprop="datePublished"';
	$article_authorMD 			= ' itemprop="author" itemscope itemtype="http://schema.org/Person"';
	$article_interactionrMD 	='<meta itemprop="interactionCount" content="UserPageVisits:'.$this->item->hits.'" />';
	$article_descriptionMD 		= ' itemprop="description"';
	$article_imageMD 			= ' itemprop="image"';
}

// remove images from print email and edit, use font icons
if ($canEdit){
		$edit_icon = preg_replace('/(<span(.*?)>|<\/span>)/s','', $edit_icon);
		$edit_icon = preg_replace('/(>(.*?)<\/a>)/s', '><i class="fa fa-pencil"></i> <em>'.JText::_('JGLOBAL_EDIT').'</em></a>', $edit_icon);
}
if ($params->get('show_email_icon')){
	$email_icon = preg_replace('/(>(.*?)<\/a>)/s', '><i class="fa fa-envelope"></i> <em>'.JText::_('JGLOBAL_EMAIL').'</em></a>', $email_icon);
}
if ($params->get('show_print_icon')){
	 
	 $print_icon = preg_replace('/(>(.*?)<\/a>)/s', '><i class="fa fa-print"></i> <em>'.JText::_('JGLOBAL_PRINT').'</em></a>', $print_icon);

}
//end

$bootstrap_version  = $yjsg->tplParam('bootstrap_version');
if(empty($bootstrap_version)){
	
	$bootstrap_version  ='bootstrapoff';
}

$author = $params->get('link_author', 0) ? JHTML::_('link',JRoute::_('index.php?option=com_users&amp;view=profile&amp;member_id='.$this->item->created_by),$this->item->author) : $this->item->author; 
$author	=($this->item->created_by_alias ? $this->item->created_by_alias : $author);

$newsitemTools = (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date')) or ($params->get('show_parent_category')) or ($params->get('show_hits') or $params->get('show_print_icon') or $params->get('show_email_icon')));
?>

<div class="yjsgarticle<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php /* Title*/if ($params->get('show_title')) : ?>
	<h2 class="article_title"<?php echo $article_nameMD ?>>
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>"<?php echo $article_urlMD ?>>
			<?php echo $this->escape($this->item->title); ?>
		</a>
		<?php else : ?>
		<?php echo $this->escape($this->item->title); ?>
		<?php endif; ?>
	</h2>
	<?php endif; ?>
	<?php  
if (!$params->get('show_intro')) :
echo $this->item->event->afterDisplayTitle;
endif; 
?>
	<?php echo $this->item->event->beforeDisplayContent; ?>
	<?php if ($newsitemTools) : ?>
	<div class="newsitem_tools">
		<div class="newsitem_info">
			<?php /* Parent category*/if ($params->get('show_parent_category')) : ?>
			<span class="fa fa-list-alt"></span>
			<span class="newsitem_parent_category details">
			<?php $title = $this->escape($this->item->parent_title);
				$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)) . '"'.$article_genreMD.'>' . $title . '</a>'; ?>
			<?php if ($params->get('link_parent_category') and $this->item->parent_slug) : ?>
			<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
			<?php else : ?>
			<?php echo JText::sprintf('COM_CONTENT_PARENT', '<span'.$article_genreMD.'>' . $title . '</span>'); ?>
			<?php endif; ?>
			</span>
			<?php endif; ?>
			<?php /*Category title*/if ($params->get('show_category')) : ?>
			<span class="newsitem_category details"><span class="fa fa-list-alt"></span>
			<?php 	$title = $this->escape($this->item->category_title);
		$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'"'.$article_genreMD.'>'.$title.'</a>';
		if ($params->get('link_category') AND $this->item->catslug) :
			echo JText::sprintf('COM_CONTENT_CATEGORY', $url);
		else:
			echo JText::sprintf('COM_CONTENT_CATEGORY','<span'.$article_genreMD.'>' . $title . '</span>');
		endif;
		?>
			</span>
			<?php endif; ?>
			<?php /* Create date*/if ($params->get('show_create_date')) : ?>
			<span class="createdate details">
			<span class="fa fa-calendar"></span>
			<time datetime="<?php echo JHtml::_('date', $this->item->created, 'c'); ?>"<?php echo $article_createdMD ?>>
				<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3'))); ?>
			</time>
			</span>
			<?php endif; ?>
			<?php /*Modify date*/ if ($params->get('show_modify_date')) : ?>
			<span class="modifydate details">
			<span class="fa fa-edit"></span>
			<time datetime="<?php echo JHtml::_('date', $this->item->modified, 'c'); ?>"<?php echo $article_modifiedMD ?>>
				<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
			</time>
			</span>
			<?php endif; ?>
			<?php /* Published date*/ if ($params->get('show_publish_date')) : ?>
			<span class="newsitem_published details"><span class="fa fa-calendar"></span>
				<time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'c'); ?>"<?php echo $article_publishedMD ?>>
					<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
				</time>
			</span>
			<?php endif; ?>
			<?php /* Author*/if ($params->get('show_author') && !empty($this->item->author)) : ?>
			<span class="createdby details"<?php echo $article_authorMD ?>>
			<span class="fa fa-pencil"></span>
			<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', '<span'.$article_nameMD.'>' . $author . '</span>'); ?>
			</span>
			<?php endif; ?>
			<?php /* Hits*/if ($params->get('show_hits')) : ?>
			<span class="newsitem_hits details"><span class="fa fa-eye"></span>
				<?php echo $article_interactionrMD ?>
				<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
			</span>
			<?php endif; ?>
		</div>
		<?php /* Email and Print*/ if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
		<div class="btn-group pull-right actiongroup">
			<?php if ($bootstrap_version !='bootstrapoff') : ?>
			<a class="btn btn-default btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="fa fa-list-ul"></span>
			</a>
			<?php endif; ?>
			<ul class="dropdown-menu articletools">
				<?php if ($params->get('show_print_icon')) : ?>
				<li class="print-icon">
					<?php echo $print_icon ?>
				</li>
				<?php endif; ?>
				<?php if ($params->get('show_email_icon')) : ?>
				<li class="email-icon">
					<?php echo $email_icon ?>
				</li>
				<?php endif; ?>
				<?php if ($canEdit) : ?>
				<li class="edit-icon">
					<?php echo $edit_icon ?>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="newsitem_text"<?php echo $article_descriptionMD?>>
		<?php  if (!empty($images->image_intro)) : ?>
		<div class="img-introtext-<?php echo $images->float_intro ?>">
			<img 
 <?php if ($images->image_intro_caption):
	echo 'class="caption"'.' title="' .$images->image_intro_caption .'"';
endif; ?>
<?php if (empty($images->float_intro)):?>
style="float:<?php echo  $params->get('float_intro') ?>"
<?php else: ?>
style="float:<?php echo  $images->float_intro ?>"
<?php endif; ?>
src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>"<?php echo $article_imageMD ?> />
		</div>
		<?php endif; ?>
		<?php /*Intro text*/
if ($fp_controll_switch == 1 ){
echo  $fp_intro_text = substr(strip_tags($this->item->introtext,
'<br><img><p><div><ul><li><a><strong><b><h1><h2><h3><h4><h5><h6><span>'),0,$fp_chars_limit)."$fp_after_text";
}else{
echo $this->item->introtext; 
} 
?>
	</div>
	<?php /* Read more link*/ if ($params->get('show_readmore') && $this->item->readmore) :
if ($params->get('access-view')) :
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
else :
$menu = JFactory::getApplication()->getMenu();
$active = $menu->getActive();
$itemId = $active->id;
$link1 = JRoute::_('index.php?option=com_users&amp;view=login&amp;Itemid='. $itemId);
$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
$link = new JURI($link1);
$link->setVar('return', base64_encode($returnURL));
endif;
?>
	<a class="readon" href="<?php echo $link; ?>">
		<span>
		<?php 
if (!$params->get('access-view')) :
echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
elseif ($readmore = $this->item->alternative_readmore) :
echo $readmore;
echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
elseif ($params->get('show_readmore_title', 0) == 0) :
echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');	
else :
echo JText::_('COM_CONTENT_READ_MORE');
echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
endif; 
?>
		</span>
	</a>
	<?php endif; ?>
</div>
<span class="article_separator">&nbsp;</span>
<?php echo $this->item->event->afterDisplayContent; ?>
