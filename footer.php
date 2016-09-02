<?php if (is_fullwidth()): ?></div><?php endif; ?>
</div>
<footer>
    <script type="application/ld+json">
      <?php
        $header_lockup_img_url = get_theme_mod('header_lockup_img_setting', '');
        $home_url = home_url();
        $logo = (!empty($header_lockup_img_url)) ? $header_lockup_img_url : get_template_directory_uri() . '/library/images/northwestern-university.png';
        $logo_name = (!empty($header_lockup_img_url)) ? 'Northwestern University Logo' : get_bloginfo('name') . ' Logo';
        $social_media_urls = array();
        $social_media_output = '';
        $social_media_options = get_supported_social_media();
        foreach ($social_media_options as $social_media_option) {
            $key = str_replace(' ', '-', strtolower($social_media_option));
            $social_media_setting_key = 'footer_social_media_links_' . $key . '_setting';
            $social_media_account_url = get_theme_mod($social_media_setting_key, '');
            if (!empty($social_media_account_url)) {
                $social_media_urls[] = $social_media_account_url;
                $social_media_output .= '<a class="social ' . $key . '" href="' . $social_media_account_url . '" itemprop="sameAs"></a>';
            }
        }
        $organization = (object)[
            '@context' => 'http://schema.org',
            '@type' => 'Organization',
            '@id' => $home_url . '/#organization',
            'url' => $home_url . '/',
            'mainEntityOfPage' => $home_url . '/',
            'name' => get_bloginfo('name'),
            'logo' => (object)[
                '@context' => 'http://schema.org',
                '@type' => 'ImageObject',
                'url' => $logo,
                'width' => '170',
                'height' => '52',
                'name' => $logo_name
            ],
            'parentOrganization' => (object)[
                '@context' => 'http://schema.org',
                '@type' => 'CollegeOrUniversity',
                'name' => 'Northwestern University',
                'url' => 'http://www.northwestern.edu/',
                'mainEntityOfPage' => 'http://www.northwestern.edu/',
                'sameAs' => array(
                    'https://en.wikipedia.org/wiki/Northwestern_University',
                    'https://www.facebook.com/NorthwesternU',
                    'http://www.twitter.com/northwesternu',
                    'https://instagram.com/northwesternu',
                    'https://www.youtube.com/user/NorthwesternU',
                    'http://www.futurity.org/university/northwestern-university/'
                ),
                'address' => '633 Clark Street, Evanston, IL 60208',
                'logo' => get_template_directory_uri() . '/library/images/northwestern-university.svg',
                'telephone' => array(
                    '(847) 491-3741',
                    '(312) 503-8649'
                ),
                'naics' => '611310'
            ]
        ];
        if (!empty($social_media_urls))
            $organization->sameAs = $social_media_urls;

        // TODO Address
        // TODO Phone

        echo json_encode($organization, JSON_UNESCAPED_SLASHES);
        ?>

    </script>

    <div id="footer-publisher-info" class="contain-970" itemprop="publisher" itemscope
         itemtype="http://schema.org/Organization" itemid="<?php echo home_url(); ?>#footer-publisher-info">
        <meta itemprop="name" content="<?php bloginfo('name'); ?>" hidden/>
        <link itemprop="url mainEntityOfPage" href="<?= $home_url ?>"/>
        <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject" hidden>
          <meta itemprop="url" content="<?= $logo ?>"/>
          <meta itemprop="width" content="170"/>
          <meta itemprop="height" content="52"/>
          <meta itemprop="name" content="<?= $logo_name ?>"/>
        </span>
        <div class="footer-content" itemprop="parentOrganization" itemscope        itemtype="http://schema.org/CollegeOrUniversity">
            <?php if ( is_active_sidebar( 'template_left' ) ) : ?>
                <?php dynamic_sidebar( 'template_left' ); ?>
            <?php endif; ?>

        </div>
        <div class="footer-content contact">
            <?php if ( is_active_sidebar( 'template_left_center' ) ) : ?>
                <?php dynamic_sidebar( 'template_left_center' ); ?>
            <?php endif; ?>
        </div>
        <div class="footer-content">
            <p><strong>Social Media</strong></p>
            <a class="social rss" href="<?php bloginfo('rss2_url'); ?>"></a>
            <?= $social_media_output ?>
        </div>
        <div class="footer-content">
            <?php wp_nav_menu(array('theme_location' => 'footer-links', 'depth' => 1)); ?>
        </div>
    </div>
</footer>
<script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@id": "<?php echo home_url(); ?>/#website",
        "@type": "WebSite",
        "url": "<?php echo home_url(); ?>/",
        "name": "<?php bloginfo('name'); ?>",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "<?php echo home_url(); ?>/?s={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },

</script>

<?php wp_footer(); ?>

</body>

</html> <!-- end of site. what a ride! -->
