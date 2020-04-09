<?php

header('Content-Type: text/xml');

$https = 'https://guestvox.com';
$database = new mysqli('guestvox.com', 'guestvox', 'Jsw90w&6', 'gv-website');

$xml =
'<?xml version="1.0" encoding="iso-8859-1"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>' . $https . '/</loc>
        <changefreq>yearly</changefreq>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>' . $https . '/hola/operacion/</loc>
        <changefreq>yearly</changefreq>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>' . $https . '/hola/reputacion/</loc>
        <changefreq>yearly</changefreq>
        <priority>1.00</priority>
    </url>';

if (!$database->connect_error)
{
    $query1 = $database->query('SELECT path FROM accounts');

    if ($query1->num_rows > 0)
    {
        while ($row = $query1->fetch_assoc())
        {
            $xml .=
            '<url>
                <loc>' . $https . '/' . $row['path'] . '/myvox/</loc>
                <changefreq>daily</changefreq>
                <priority>1.00</priority>
            </url>
            <url>
                <loc>' . $https . '/' . $row['path'] . '/reviews/</loc>
                <changefreq>daily</changefreq>
                <priority>1.00</priority>
            </url>';
        }
    }
}

$xml .=
'   <url>
        <loc>' . $https . '/signup/</loc>
        <changefreq>yearly</changefreq>
        <priority>0.80</priority>
    </url>
</urlset>';

$database->close();

echo $xml;
