<?php

abstract class TimeeditWebsiteAlgorithmParser extends WebsiteAlgorithmParser
{

    const PARSER_EXCEPTION_WRONGVERSION = "wrongversion";
    const PARSER_EXCEPTION_INCORRECTTYPE = "incorrecttype";
    const PARSER_EXCEPTION_INCORRECTPATH = "incorrectpath";
    const PARSER_EXCEPTION_TOOMANYWEEKS = "toomanyweeks";

    public static $TYPES = array ( TypeScheduleModel::TYPE_FACULTY => 6, TypeScheduleModel::TYPE_GROUP => 5,
            TypeScheduleModel::TYPE_PROGRAM => 4, TypeScheduleModel::TYPE_ROOM => 7 );

}

?>