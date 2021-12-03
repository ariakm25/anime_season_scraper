<?php include(__DIR__ . '/includes/header.php'); ?>
<div class="container">

  <h1 class="title">List Anime <?php echo $data['seasonName'] ?></h1>

  <?php foreach ($data['list'] as $type) { ?>
    <h2 class="type-title"><?php echo $type['typeName'] ?></h2>
    <div class="item-wrapper">
      <?php foreach ($type['animes'] as $anime) { ?>
        <article class="item">
          <a target="_blank" href="<?php echo $anime['url'] ?>" title="<?php echo $anime['title'] ?>">
            <img src="<?php echo $anime['image'] ?>">
          </a>
          <div class="info">
            <a target="_blank" href="<?php echo $anime['url'] ?>">
              <h2><?php echo $anime['title'] ?></h2>
            </a>
            <div class="genres">
            <?php echo implode(', ', $anime['genres']) ?>
            </div>
            <div class="meta">
              <span class="rating">
                <span class="star">&#9733;</span><?php echo $anime['score'] ?></span> |
              <span class="season">
                <?php echo $anime['member'] ?>
              </span>
              |
              <span class="eps">
                <?php echo $anime['eps'] ?>
              </span>
              |
              <span class="producer">
                <?php echo $anime['producer'] ?>
              </span>
            </div>
          </div>
        </article>
      <?php } ?>
    </div>
  <?php } ?>

</div>
<?php include(__DIR__ . '/includes/footer.php'); ?>