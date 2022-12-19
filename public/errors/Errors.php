<?php
namespace public\errors;

enum Errors: int
{
    case VIDEO_NOT_FOUND = 1;
    case COMMENT_NOT_FOUND = 2;
    case REGISTER_FAILED = 3;
    case LOGIN_FAILED = 4;
    case COMMENT_DETAILS_NOT_FOUND = 5;
}
