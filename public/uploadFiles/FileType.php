<?php
namespace public\uploadFiles;

enum FileType: int
{
    case THUMBNAIL = 1;
    case PROFILE_PICTURE = 2;
    case VIDEO = 3;
}
