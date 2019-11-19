/**
 * Объект для работы с cdn
 *
 * @author kamaelkz <kamaelkz@yandex.kz>
 */
var legalCdnUtility = {

    webPrefix: 'web',
    staticPrefix: 'static',

    /**
     * Префикс пути с cdn
     */
    cdnPrefix : 'cdn/static/',

    /**
     * Стратегии загрузки
     */
    strategies : {
        default : 'default',
        trusted : 'trusted',
        by_request : 'by_request',
        profile : 'profile',
        blog : 'blog',
        comment : 'comment',
        carousel : 'carousel',
    },

    /**
     * Авторизация
     *
     * @param payload
     * @param callback
     */
    auth : function(payload, callback, async = true) {
        $.ajax({
            url: '/cdn/',
            type: 'POST',
            data: payload,
            async: async,
            success: function (response) {
                callback(response);
            }
        });
    },

    /**
     * Признак подключения cdn
     */
    isEnabled : function () {
        return true;
    },

    /**
     * Приводит ответ к старой структуре закгрузки
     *
     * @todo параметр что искать в тумбах thumb|100x68
     *
     * @param response
     * @param thumbPrefix
     * @param callbackItem // претендент на удаление
     */
    parseResponse : function(response, processItemCallback)
    {
        var result = [];
        var self = this;
        //оригинальные изображения
        $.each(response, function(originIndex, originInfo) {
            // var item = originInfo;
            self.fillResponse(result, originIndex, originInfo);
            if(originInfo.thumbs.length > 0) {
                $.each(originInfo.thumbs, function (thumbsIndex, thumbsInfo){
                    if(thumbsInfo.thumbAlias !== undefined) {
                        result[originIndex]['thumbs'] = {};
                        self.fillResponse(result[originIndex]['thumbs'], thumbsInfo.thumbAlias, thumbsInfo);
                        // item = thumbsInfo;
                    }
                });
            }

            // TODO не уверен что нужно, пусть пока полежит
            // if(
            //     processItemCallback !== undefined
            //     && typeof processItemCallback === 'function'
            // ) {
            //     processItemCallback(item);
            // }
        });

        return result;
    },


    /**
     * Преобразование ответа с cdn
     *
     * @param array|object items
     * @param string|integer index
     * @param object info
     */
    fillResponse: function(items, index,  info)
    {
        items[index] = {
            id : info.id,
            path: this.parsePath(info.path),
            url: this.parseUrl(info.url),
            size: info.size
        };

        if(info.height !== undefined) {
            items[index].height = info.height;
        }

        if(info.height !== undefined) {
            items[index].width = info.width
        }

        if(info.ratio !== undefined) {
            items[index].ratio = info.ratio;
        }
    },

    /**
     * Преобразует адрес файла для отдачи
     *
     * @param url
     */
    parseUrl : function(url)
    {
        return url.replace(this.cdnPrefix, 'static/');
    },

    /**
     * Преобразует путь к файлу
     *
     * @param path
     */
    parsePath : function(path)
    {
        return path.replace(this.cdnPrefix, 'static/');
    },

    /**
     * Для случаев когда асболютный адрес нужно преобразовать в путь на legacdn (для удаления/кропа и.т)
     *
     * @param string domain
     * @param string url
     * @returns string
     */
    pathFromUrl(domain, url)
    {
        var result = url.replace(domain, '');

        return "/" + this.staticPrefix  + result;
    },

    /**
     * Получение содержимого файла в формате base64
     *
     * @param string url
     * @param function callback
     */
    getBase64(url, callback) {
        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            var reader = new FileReader();
            reader.onloadend = function() {
                if(
                    callback !== undefined
                    && typeof callback === 'function'
                ) {
                    callback(reader.result);
                }
            }

            reader.readAsDataURL(xhr.response);
        };

        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }
};