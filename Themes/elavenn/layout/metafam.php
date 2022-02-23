<html xmlns:fb="//www.facebook.com/2008/fbml">





<?php  ?>

<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<meta name="title" content="<?php echo $wo['title'];?>">
<meta name="description" content="<?php echo $wo['description'];?>">
<meta name="keywords" content="<?php echo $wo['keywords'];?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="pinterest-rich-pin" content="false" />
<?php if ($wo['page'] == 'maintenance') { ?>
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
<?php } ?>
<?php if ($wo['page'] == 'watch_movie') { ?>
<meta property="og:title" content="<?php echo $wo['movie']['name']; ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo $wo['movie']['url']; ?>" />
<meta property="og:image" content="<?php echo $wo['movie']['cover']; ?>" />
<meta property="og:image:secure_url" content="<?php echo $wo['movie']['cover']; ?>" />
<meta property="og:description" content="<?php echo $wo['movie']['description']; ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['movie']['name']; ?>" />
<meta name="twitter:description" content="<?php echo $wo['movie']['description']; ?>" />
<meta name="twitter:image" content="<?php echo $wo['movie']['cover']; ?>" />
<?php } ?>
<?php if ($wo['page'] == 'page' && !empty($wo['page_profile'])) { ?>
<meta property="og:title" content="<?php echo $wo['page_profile']['page_name']; ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo $wo['page_profile']['url']; ?>" />
<meta property="og:image" content="<?php echo $wo['page_profile']['avatar']; ?>" />
<meta property="og:image:secure_url" content="<?php echo $wo['page_profile']['avatar']; ?>" />
<meta property="og:description" content="<?php echo $wo['page_profile']['page_description']; ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['page_profile']['page_name']; ?>" />
<meta name="twitter:description" content="<?php echo $wo['page_profile']['page_description']; ?>" />
<meta name="twitter:image" content="<?php echo $wo['page_profile']['avatar']; ?>" />
<?php } ?>
<?php if ($wo['page'] == 'group' && !empty($wo['group_profile'])) { ?>
<meta property="og:title" content="<?php echo $wo['group_profile']['group_name']; ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo $wo['group_profile']['url']; ?>" />
<meta property="og:image" content="<?php echo $wo['group_profile']['avatar']; ?>" />
<meta property="og:image:secure_url" content="<?php echo $wo['group_profile']['avatar']; ?>" />
<meta property="og:description" content="<?php echo $wo['group_profile']['about']; ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['group_profile']['group_name']; ?>" />
<meta name="twitter:description" content="<?php echo $wo['group_profile']['about']; ?>" />
<meta name="twitter:image" content="<?php echo $wo['group_profile']['avatar']; ?>" />
<?php } ?>
<?php if ($wo['page'] == 'game' && !empty($wo['game'])) { ?>
<meta property="og:title" content="<?php echo $wo['game']['game_name']; ?>" />
<meta property="og:type" content="game" />
<meta property="og:url" content="<?php echo $wo['game']['game_link']; ?>" />
<meta property="og:image" content="<?php echo $wo['game']['game_avatar']; ?>" />
<meta property="og:image:secure_url" content="<?php echo $wo['game']['game_avatar']; ?>" />
<meta property="og:description" content="<?php echo $wo['game']['game_name']; ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['game']['game_name']; ?>" />
<meta name="twitter:description" content="<?php echo $wo['game']['game_name']; ?>" />
<meta name="twitter:image" content="<?php echo $wo['game']['game_avatar']; ?>" />
<?php } ?>
<?php if ($wo['page'] == 'welcome') { ?>
<meta property="og:title" content="<?php echo $wo['title'];?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo $wo['config']['site_url'];?>" />
<meta property="og:image" content="<?php echo $wo['config']['theme_url'];?>/img/og.jpg" />
<meta property="og:image:secure_url" content="<?php echo $wo['config']['theme_url'];?>/img/og.jpg" />
<meta property="og:description" content="<?php echo $wo['description'];?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['description'];?>" />
<meta name="twitter:image" content="<?php echo $wo['config']['theme_url'];?>/img/og.jpg" />
<?php } ?>
<?php
if (!empty($wo['story']['postFile'])) {
    echo Wo_LoadPage('header/og-meta');
}
if (!empty($wo['story']['postSticker'])) {
    echo Wo_LoadPage('header/og-meta-5');
}
if (!empty($wo['story']['postLink'])) {
    echo Wo_LoadPage('header/og-meta-2');
}

if (!empty($wo['story']['product_id'])) {
    echo Wo_LoadPage('header/og-meta-4');
    // print_r($wo['story']['product']);
    // exit();
}
if ($wo['page'] == 'timeline') { ?>
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $wo['user_profile']['avatar']?>" />
<meta property="og:image:secure_url" content="<?php echo $wo['user_profile']['avatar'];?>" />
<meta property="og:description" content="<?php echo $wo['description'];?>" />
<meta property="og:title" content="<?php echo $wo['title'];?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['description'];?>" />
<meta name="twitter:image" content="<?php echo $wo['user_profile']['avatar']; ?>" />
<?php if ($wo['user_profile']['share_my_data'] == 0) { ?>
<meta name="robots" content="noindex,nofollow">
<meta name="googlebot" content="noindex">
<?php } ?>
<?php } ?>
<?php if (!empty($wo['story']['fund'])) {  ?>
<meta property="og:title" content="<?php echo $wo['story']['fund']['fund']['title'];?>" />
<meta property="og:type" content="funding" />
<meta property="og:image" content="<?php echo $wo['story']['fund']['fund']['image'];?>" />
<meta property="og:description" content="<?php echo $wo['story']['fund']['fund']['description'];?>" />
<meta name="twitter:title" content="<?php echo $wo['story']['fund']['fund']['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['story']['fund']['fund']['description'];?>" />
<meta name="twitter:image" content="<?php echo $wo['story']['fund']['fund']['image'];?>" />
<?php } ?>
<?php if (!empty($wo['story']['fund_data'])) {  ?>
<meta property="og:title" content="<?php echo $wo['story']['fund_data']['title'];?>" />
<meta property="og:type" content="funding" />
<meta property="og:image" content="<?php echo $wo['story']['fund_data']['image'];?>" />
<meta property="og:description" content="<?php echo $wo['story']['fund_data']['description'];?>" />
<meta name="twitter:title" content="<?php echo $wo['story']['fund_data']['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['story']['fund_data']['description'];?>" />
<meta name="twitter:image" content="<?php echo $wo['story']['fund_data']['image'];?>" />
<?php } ?>
<?php if (!empty($wo['fund'])) {  ?>
<meta property="og:title" content="<?php echo $wo['fund']['title'];?>" />
<meta property="og:type" content="funding" />
<meta property="og:image" content="<?php echo $wo['fund']['image'];?>" />
<meta property="og:description" content="<?php echo $wo['fund']['description'];?>" />
<meta name="twitter:title" content="<?php echo $wo['fund']['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['fund']['description'];?>" />
<meta name="twitter:image" content="<?php echo $wo['fund']['image'];?>" />
<?php } ?>
<?php if (!empty($wo['story']['job'])) {  ?>
<meta property="og:title" content="<?php echo $wo['story']['job']['title'];?>" />
<meta property="og:type" content="job" />
<meta property="og:image" content="<?php echo Wo_GetMedia($wo['story']['job']['image']);?>" />
<meta property="og:description" content="<?php echo $wo['story']['job']['description'];?>" />
<meta name="twitter:title" content="<?php echo $wo['story']['job']['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['story']['job']['description'];?>" />
<meta name="twitter:image" content="<?php echo Wo_GetMedia($wo['story']['job']['image']);?>" />
<?php } ?>
<?php if ($wo['page'] == 'read-blog') { ?>
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $wo['article']['thumbnail']?>" />
<meta property="og:image:secure_url" content="<?php echo $wo['article']['thumbnail']?>" />
<meta property="og:description" content="<?php echo $wo['article']['description'];?>" />
<meta property="og:title" content="<?php echo $wo['article']['title'];?>" />
<meta property="og:url" content="<?php echo $wo['article']['url'];?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $wo['article']['title'];?>" />
<meta name="twitter:description" content="<?php echo $wo['article']['description'];?>" />
<meta name="twitter:image" content="<?php echo $wo['article']['thumbnail']; ?>" />
