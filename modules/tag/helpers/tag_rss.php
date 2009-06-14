<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2009 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

class tag_rss_Core {
  static function available_feeds($item) {
    return array(array("description" => t("Tag Album feed"),
                       "type" => "head",
                       "uri" => "tags"));
  }

  static function tags($offset, $limit, $id) {
    $tag = ORM::factory("tag", $id);
    if (!$tag->loaded) {
      return Kohana::show_404();
    }

    $feed["children"] = $tag->items($limit, $offset, "photo");
    $feed["max_pages"] = ceil($tag->count / $limit);
    $feed["title"] = $tag->name;
    $feed["link"] = url::abs_site("tags/{$tag->id}");
    $feed["description"] = t("Photos related to %tag_name", array("tag_name" => $tag->name));

    return $feed;
  }
}
