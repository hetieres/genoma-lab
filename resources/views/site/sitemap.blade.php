<?xml version="1.0" encoding="UTF-8"?>

@if (!isset($internal))
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        @for ($i = 1; $i < $pagesNews; $i++)
            <sitemap>
                <loc>{{ url('/sitemap.xml/news/' . $i ) }}</loc>
            </sitemap>
        @endfor

        <sitemap>
            <loc>{{ url('/sitemap.xml/news-brazil') }}</loc>
        </sitemap>

        <sitemap>
            <loc>{{ url('/sitemap.xml/news-world') }}</loc>
        </sitemap>

        <sitemap>
            <loc>{{ url('/sitemap.xml/news-country') }}</loc>
        </sitemap>

        <sitemap>
            <loc>{{ url('/sitemap.xml/news-years') }}</loc>
        </sitemap>

        <sitemap>
            <loc>{{ url('/sitemap.xml/vehicles-brazil') }}</loc>
        </sitemap>

        <sitemap>
            <loc>{{ url('/sitemap.xml/vehicles-world') }}</loc>
        </sitemap>

        <sitemap>
            <loc>{{ url('/sitemap.xml/plataforms') }}</loc>
        </sitemap>
    </sitemapindex>
@elseif ($request->slug == 'news')
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
        @foreach ($pages as $page)
            <url>
                <loc>{{ url('/' . (!is_null($slug) ? $slug . '/' : '') . (!is_null($gets) ? $gets . $page->name : str_slug($page->name) . '/' . $page->id)) }}</loc>
                <changefreq>{{ $changes }}</changefreq>
                <priority>{{ $priority }}</priority>
                <news:news>
                    <news:publication>
                        <news:name><![CDATA[{{ $page->name }}]]></news:name>
                        <news:language>pt-br</news:language>
                    </news:publication>
                    <news:publication_date>{{ $page->dt_publication->format('Y-m-d') }}</news:publication_date>
                    <news:title><![CDATA[{{ $page->name }}]]></news:title>
                </news:news>
            </url>
        @endforeach
    </urlset>
@else
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        @if (isset($raw) && !is_null($raw))
            <url>
                <loc>{{ url('/' . $raw) }}</loc>
                <changefreq>{{ $changes }}</changefreq>
                <priority>{{ ($priority + 0.1) }}</priority>
            </url>
        @endif

        @foreach ($pages as $page)
            <url>
                <loc>{{ url('/' . (!is_null($slug) ? $slug . '/' : '') . (!is_null($gets) ? $gets . $page->name : str_slug($page->name) . '/' . $page->id)) }}</loc>
                <changefreq>{{ $changes }}</changefreq>
                <priority>{{ $priority }}</priority>
            </url>
        @endforeach
    </urlset>
@endif