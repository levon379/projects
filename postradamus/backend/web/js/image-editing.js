/**
 * Created by Nate on 10/10/14.
 */
function createImageFromJson(object, canvas)
{
    canvas.setWidth(object.width);
    canvas.setHeight(object.height);

    var main_img = canvas.getItemByName('master');

    main_img.selectable = false;

    canvas.renderAll();

    main_img.toObject = (function(toObject) {
        return function() {
            return fabric.util.object.extend(toObject.call(this), {
                name: this.name
            });
        };
    })(main_img.toObject);
    main_img.name = 'master';

    var objs = canvas.getObjects().map(function(obj) {
        obj.toObject = (function(toObject) {
            return function() {
                return fabric.util.object.extend(toObject.call(this), {
                    position_x: this.x,
                    position_y: this.y
                });
            };
        })(obj.toObject);
        obj.x = obj.position_x;
        obj.y = obj.position_y;
    });
}

function createImageFromUrl(img, canvas)
{
    //img.selectable = false;

    original_width = img.width;
    original_height = img.height;

    //console.log('original width: ' + original_width);
    //console.log('original height: ' + original_height);

    if(img.getWidth() < 870)
    {
        width = original_width;
        height = original_height;
    }
    else
    {
        width = 870;
        height = Math.round((original_height * width) / original_width);
    }
    img.height = height;
    img.width = width;

    //console.log('new width: ' + width);
    //console.log('new height: ' + height);

    canvas.setWidth(width);
    canvas.setHeight(img.getHeight());
    canvas.add(img);

    //console.log('canvas width: ' + canvas.getWidth());
    //console.log('canvas height: ' + canvas.getHeight());

    img.toObject = (function(toObject) {
        return function() {
            return fabric.util.object.extend(toObject.call(this), {
                name: this.name
            });
        };
    })(img.toObject);
    img.name = 'master';
}

function saveImage(id, save_url, redirect, post_count, canvas)
{
    canvas.deactivateAll().renderAll();
    image_data = canvas.toDataURL();
    image_json_data = JSON.stringify(canvas.toJSON(['width', 'height']));

    $.ajax({
        xhr: function()
        {
            var xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    //console.log(percentComplete);
                }
            }, false);
            //Download progress
            xhr.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with download progress
                    //console.log(percentComplete);
                }
            }, false);
            return xhr;
        },
        type: 'POST',
        url: save_url,
        data: {
            id: id,
            image_json_data: image_json_data,
            image_data: image_data
        },
        success: function(data){
            //console.log(data);
            data = JSON.parse(data);
            completed += 1;
            if(completed >= post_count)
            {
                $('.progress-bar').css('width', '100%');
                $('.msg').text('Done!');
                location.href=redirect;
            }
            //Do something success-ish
            $('#item-' + id + ' .image_link').attr('href', data.img_url + "?" + Math.random());
            $('#item-' + id + ' .image_link > img').attr('src', data.img_url + "?" + Math.random());
        }
    });
}

function addMeme(canvas)
{
    var text1 = new fabric.IText('Top Text', {
        fill: '#fff',
        fontFamily: 'impact',
        strokeWidth: 1,
        stroke: 'black'
    });
    canvas.add(text1);
    text1.setTop(10).setCoords();
    text1.setLeft(canvas.width / 2 - text1.getBoundingRectWidth() / 2).setCoords();

    var text2 = new fabric.IText('Bottom Text', {
        fill: '#fff',
        fontFamily: 'impact',
        strokeWidth: 1,
        stroke: 'black'
    });
    canvas.add(text2);
    text2.setTop(canvas.height - text2.getBoundingRectHeight() - 10).setCoords();
    text2.setLeft(canvas.width / 2 - text2.getBoundingRectWidth() / 2).setCoords();

    canvas.renderAll();
}

function scale(object, canvas)
{
    original_canvas_width = canvas.width;
    original_canvas_height = canvas.height;
    original_object_width = object.getBoundingRect().width; //object.getBoundingRect().width
    original_object_height = object.getBoundingRect().height; //object.getBoundingRect().height

    new_object_height = (original_object_height * canvas.height) / original_canvas_height;
    new_object_width = (original_object_width * canvas.width) / original_canvas_width;

    //console.log('old height: ' + original_object_height);
    //console.log('old width: ' + original_object_width);

    //console.log('new height: ' + new_object_height);
    //console.log('new width: ' + new_object_width);

    //resize
    object.scaleToHeight(new_object_height);
    object.scaleToWidth(new_object_width);

    //resize DOWN if needed
    if(new_object_height > canvas.height)
    {
        object.scaleToHeight(canvas.height);
    }
    if(new_object_width > canvas.width)
    {
        object.scaleToWidth(canvas.width);
    }
    canvas.renderAll();
    return object;
}

function addImage(x, y, image_url, opacity, canvas)
{
    img = new fabric.Image($("img[src='" + image_url + "']")[0], {
        opacity: opacity
    });

    canvas.add(img);

    scale(img, canvas);

    moveObject(img, x, y, canvas);

    canvas.renderAll();
    return img;
}

function moveObject(obj, x, y, canvas) {
    //console.log(x, y);
    //assign position x and y
    obj.toObject = (function(toObject) {
        return function() {
            return fabric.util.object.extend(toObject.call(this), {
                position_x: this.x,
                position_y: this.y
            });
        };
    })(obj.toObject);

    obj.x = x;
    obj.y = y;

    //apply the position

    if(x == 1)
    {
        obj.setLeft(0).setCoords();
    }
    if(x == 2)
    {
        obj.setLeft(canvas.width / 2 - obj.getBoundingRect().width / 2).setCoords();
    }
    if(x == 3)
    {
        obj.setLeft(canvas.width - obj.getBoundingRect().width - 0).setCoords();
    }

    if(y == 1)
    {
        obj.setTop(0).setCoords();
    }
    if(y == 2)
    {
        obj.setTop(canvas.height / 2 - obj.getBoundingRect().height / 2).setCoords();
    }
    if(y == 3)
    {
        obj.setTop(canvas.height - obj.getBoundingRect().height - 0).setCoords();
    }

    canvas.renderAll();
    return obj;
}

function lockMovement(canvas) {
    var objs = canvas.getObjects().map(function(o) {
        //lock movement
        o.set('lockMovementX', true);
        o.set('lockMovementY', true);
        return o;
    });
}

function addText(x, y, text, font_family, font_color, font_size, opacity, canvas)
{
    text = new fabric.IText(text, {
        fill: font_color,
        fontFamily: font_family,
        fontSize: font_size,
        //backgroundColor: '#ffffff',
        strokeWidth: 1,
        stroke: 'black',
        fontWeight: 'bold',
        opacity: opacity
    });

    canvas.add(text);

    text = scale(text, canvas);

    if(text.getBoundingRect().width > canvas.width)
    {
        text.scaleToWidth(canvas.width - 10);
    }

    //resize text so its not any wider or taller than the canvas
    if(text.getBoundingRect().height > canvas.height)
    {
        text.scaleToHeight(canvas.height - 10);
    }

    moveObject(text, x, y, canvas);

    canvas.renderAll();
    return text;
}

fabric.Canvas.prototype.getItemByName = function(name) {
    var object = null,
        objects = this.getObjects();

    for (var i = 0, len = this.size(); i < len; i++) {
        if (objects[i].name && objects[i].name === name) {
            object = objects[i];
            break;
        }
    }
    return object;
};