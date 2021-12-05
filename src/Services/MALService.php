<?php

namespace App\Services;

use voku\helper\HtmlDomParser;

class MALService
{
    private $baseTarget = 'https://myanimelist.net';

    private function init($path)
    {
        $curl = curl_init($this->baseTarget . $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $html = curl_exec($curl);
        curl_close($curl);

        return HtmlDomParser::str_get_html($html);
    }

    public function getCurrentAnimeSeason()
    {
        $html = $this->init('/anime/season');

        $wrapper = $html->findOne('#contentWrapper');
        $data['seasonName'] = $wrapper->findOne('.season_nav > a')->innerText();

        // Get the current anime season types
        foreach ($wrapper->findMulti('.js-categories-seasonal > .seasonal-anime-list.js-seasonal-anime-list') as $index => $animeType) {
            $typeName = $animeType->findOne('.anime-header')->innerText();

            $data['list'][$index] = [
                'typeName' => $typeName,
                'animes' => []
            ];

            // Get the anime list from each types
            foreach ($animeType->findMulti('.seasonal-anime.js-seasonal-anime') as $anime) {

                // Get the genres anime
                $genres = [];
                foreach ($anime->findMulti('.genres-inner > .genre') as $genre) {
                    $genreName = $genre->findOne('a')->innerText();
                    // Skip 18+ anime
                    if (strtolower($genreName) == 'hentai') continue 2;
                    $genres[] = $genreName;
                }

                // Get image anime
                $image = $anime->findOne('.image > a > img')->getAttribute('data-src');
                $image = $image != null ? $image : $anime->findOne('.image > a > img')->getAttribute('src');

                // Anime Data
                $data['list'][$index]['animes'][] = [
                    'title' => $anime->findOne('.h2_anime_title > a')->innerText(),
                    'url' => $anime->findOne('.h2_anime_title > a')->getAttribute('href'),
                    'image' => $image,
                    'score' => strip_tags($anime->findOne('.score.score-label')->innerText()),
                    'member' => strip_tags($anime->findOne('.member.fl-r')->innerText()),
                    'producer' => $anime->findOne('.producer > a')->innerText(),
                    'eps' => $anime->findOne('.eps > a > span')->innerText(),
                    'source' => $anime->findOne('.source')->innerText(),
                    'genres' => $genres
                ];
            }
        }

        return $data;
    }
}
