<?php

namespace pkmnfriends\Domain\Files\Files\Access;

class DontShowFilesStartingWithDot
{

    /**
     * @param $attr
     * @param $path
     * @param $data
     * @param $volume
     *
     * @return bool|null
     */
    public static function checkAccess($attr, $path, $data, $volume)
    {
        // if file/folder begins with '.' (dot)
        return 0 === strpos(basename($path), '.')
            // set read+write to false, other (locked+hidden) set to true
            ? !($attr === 'read' || $attr === 'write')
            // else elFinder decide it itself
            : null;
    }
}
