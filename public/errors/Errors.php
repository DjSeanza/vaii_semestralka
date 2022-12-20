<?php
namespace public\errors;

enum Errors: int
{
    case VIDEO_NOT_FOUND = 1;
    case COMMENT_NOT_FOUND = 2;
    case REGISTER_FAILED = 3;
    case UPDATE_USER_DATA_FAILED = 4;
    case LOGIN_FAILED = 5;
    case COMMENT_DETAILS_NOT_FOUND = 6;
    case FILE_TOO_LARGE = 7;
    case WRONG_FILE_FORMAT = 8;
    case FILE_NOT_UPLOADED = 9;
    case UNEXPECTED_ERROR = 10;
    case USERNAME_EXISTS = 11;
}
