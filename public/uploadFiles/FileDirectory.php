<?php
namespace public\uploadFiles;

enum FileDirectory: string
{
    case PROFILE_PICTURE = "public/uploads/users/";
    case THUMBNAIL_WITH_CONTENT = "public/uploads/videos/";
}
