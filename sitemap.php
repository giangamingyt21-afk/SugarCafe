<?php
header('Content-Type: application/xml; charset=UTF-8');

$baseUrl = 'http://localhost/sugar-cafe';
$pages = [
    ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
    ['url' => '/menu.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/about.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['url' => '/gallery.php', 'priority' => '0.6', 'changefreq' => 'weekly'],
    ['url' => '/contact.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['url' => '/promotions.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/rewards.php', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['url' => '/faq.php', 'priority' => '0.5', 'changefreq' => 'monthly'],
    ['url' => '/privacy-policy.php', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ['url' => '/terms.php', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ['url' => '/login.php', 'priority' => '0.4', 'changefreq' => 'monthly'],
    ['url' => '/register.php', 'priority' => '0.4', 'changefreq' => 'monthly'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
    <url>
        <loc><?php echo $baseUrl . $page['url']; ?></loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq><?php echo $page['changefreq']; ?></changefreq>
        <priority><?php echo $page['priority']; ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
