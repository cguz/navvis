// para corregir la ruta cuando se esta en el admin
var ruta_url = '';

// De la plantilla inicial
function newImage(arg)
{
    if (document.images)
    {
        rslt = new Image();
        rslt.src = arg;
        return rslt;
    }
}

function changeImages()
{
    if (document.images && (preloadFlag == true))
    {
        for (var i=0; i<changeImages.arguments.length; i+=2)
        {
            document[changeImages.arguments[i]].src = changeImages.arguments[i+1];
        }
    }
}

var preloadFlag = false;
function preloadImages()
{
    if (document.images)
    {
        company_over = newImage(ruta_url + "images/home-over.gif");
        services_over = newImage(ruta_url + "images/crear_anuncio-over.gif");
        partners_over = newImage(ruta_url + "images/se_vende-over.gif");
        news_over = newImage(ruta_url + "images/se_compra-over.gif");
        careers_over = newImage(ruta_url + "images/ayuda-over.gif");
        preloadFlag = true;
    }
}
// --------------------------

function cambiarImagen(nombre_imagen, over)
{
    // window.status = nombre_imagen;
    
    if (over)
    {
        changeImages(nombre_imagen, ruta_url + 'images/' + nombre_imagen + '-over.gif');
    }
    else
    {
        changeImages(nombre_imagen, ruta_url + 'images/' + nombre_imagen + '.gif');
    }
    return true;
}

// Recarga la página cuando cambian la vista de ver o no las fotos de los enunciados
function clic_fotos(valor)
{
    document.forms[0].fotos.value = valor;
    document.forms[0].submit();
}

// Recarga cuando cambian de página (paginación)
function clic_pagina(valor)
{
    if (valor > 0 && valor <= document.forms[0].total_paginas.value)
    {
        document.forms[0].pagina.value = valor;
        document.forms[0].submit();
    }
    else
    {
        alert("Número de página no permitido");
    }
}

// En la administracion selecciona todos los checks de los anuncios
function todos()
{
    var total = document.forms[0].total_mostrados.value;
    
    for (var i = 0; i < total; i++)
    {
        eval("document.getElementById('check_" + i + "').checked = true;");
    }
}

// En la administracion quita la selección de todos los checks de los anuncios
function ninguno()
{
    var total = document.forms[0].total_mostrados.value;
    
    for (var i = 0; i < total; i++)
    {
        eval("document.getElementById('check_" + i + "').checked = false;");
    }
}

// Presenta el campo de comentario cuando dan clic en el botón Publicar
function publicar_clic()
{
    document.getElementById('publicar_boton').style.display = 'none';
    document.getElementById('no_publicar_boton').style.display = '';
    document.getElementById('publicar').style.display = '';
    document.getElementById('no_publicar').style.display = 'none';
    document.getElementById('td_comentario').style.display = 'block';
}

// Presenta el campo de comentario cuando dan clic en el botón Publicar
function no_publicar_clic()
{
    document.getElementById('publicar_boton').style.display = '';
    document.getElementById('no_publicar_boton').style.display = 'none';
    document.getElementById('publicar').style.display = 'none';
    document.getElementById('no_publicar').style.display = '';
    document.getElementById('td_comentario').style.display = 'block';
}

// Presenta el campo de comentario cuando dan clic en el botón Publicar
function cancelar_clic()
{
    document.getElementById('publicar_boton').style.display = '';
    document.getElementById('no_publicar_boton').style.display = '';
    document.getElementById('td_comentario').style.display = 'none';
}
