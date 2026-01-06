<?php echo $header; ?>
<?php echo $menuinner; ?>
<div id="smooth-wrapper">
    <div id="smooth-content">
        <div class="main-container">
            <?php if (!empty($getPages)) : ?>
                <section>
                    <div class="privacy-policy">
                        <div class="container">
                            <div class="privacy-policy-inn">
                                <div class="privacy-p-title">
                                    <h2><?php echo  $getPages['name']; ?></h2>
                                </div>
                                <div class="privacy-p-content">
                                    <div class="privacy-p-content-inn">
                                        <?php echo  $getPages['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?php echo $footer; ?>