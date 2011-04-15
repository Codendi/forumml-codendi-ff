<?php
/**
 * Copyright (c) STMicroelectronics, 2004-2009. All rights reserved
 *
 * This file is a part of Codendi.
 *
 * Codendi is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Codendi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Codendi. If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'ForumML_AttachmentDao.class.php';

class ForumML_Attachment {
    private $_dao;

    function getById($id) {
        $attach = null;
        $dar    = $this->getDao()->getById($id);
        if ($dar && !$dar->isError()) {
            $attch = $dar->current();
            $attch['type'] = $this->getType($attch);
        }
        return $attch;
    }

    /**
     * Return attachment mime type
     *
     * Try to get it from the db and if it fails, try with filename
     */
    function getType($row) {
        /*if (preg_match('/^[ ]*(.*\/.*)[ ]*;?.*$/', $row['file_type'], $matches)) {
            $type = $matches[1];
        } else {
            // Retrieve the uploaded file type
            switch(strtoupper(strrchr($row['file_name'], "."))) {
            case ".GZ":
                $type = "application/x-gzip";
                break;
            case ".TGZ":
                $type = "application/x-gzip";
                break;
            case ".ZIP":
                $type = "application/zip";
                break;
            case ".PDF":
                $type = "application/pdf";
                break;
            case ".PNG":
                $type = "image/png";
                break;
            case ".GIF":
                $type = "image/gif";
                break;
            case ".JPG":
                $type = "image/jpeg";
                break;
            case ".TXT":
                $type = "text/plain";
                break;
            case ".HTM":
                $type = "text/html";
                break;
            case ".HTML":
                $type = "text/html";
                break;
            default:
                $type = "application/octet-stream";
                break;
            }
        }
        return $type;*/
	return mime_content_type($row['file_path']);
    }

    function getDao() {
        if (!isset($this->_dao)) {
            $this->_dao = new ForumML_AttachmentDao(CodendiDataAccess::instance());
        }
        return $this->_dao;
    }

}

?>
