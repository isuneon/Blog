#
# Definition for the `ObtenerInformacionBlog` procedure : 
#

DROP PROCEDURE IF EXISTS `ObtenerInformacionBlog`;

CREATE PROCEDURE `ObtenerInformacionBlog`(IN idBlog INTEGER(11))
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
     SELECT * from `blog` WHERE id = idBlog;
END;

#
# Definition for the `ObtenerInformacionBlogs` procedure : 
#

DROP PROCEDURE IF EXISTS `ObtenerInformacionBlogs`;

CREATE PROCEDURE `ObtenerInformacionBlogs`()
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
     SELECT * FROM `blog`;
END;

