$(document).ready(function () {
    const imagesSelectors = {
        wrapper: '.images-wrapper'
    }

    if(window.FileReader) {
        const thumbnailEl = $("#thumbnail");
        const imagesEl = $("#images");

        thumbnailEl.on('change', onChangeThumbnail);
        imagesEl.on('change', onChangeImages);
    }


    function onChangeThumbnail(e) {
        const reader = new FileReader();
        reader.onloadend = (e) => {
            $('#thumbnail-preview').attr('src', e.target.result).removeClass('d-none');
        }

        reader.readAsDataURL(this.files[0]);
    }

    function onChangeImages(e) {
        let counter = 0;
        let file;

        const template = '<div class="mb-4 text-center"><img src="_url_" style="width: 50%" /></div>'

        $(imagesSelectors.wrapper).html('');


        while(file = this.files[counter++]) {
            const reader = new FileReader()
            reader.onloadend = function() {
                return function(e) {
                    const img = template.replace('_url_', e.target.result)
                    $(imagesSelectors.wrapper).append(img)
                }
            }

            (file);
            reader.readAsDataURL(file)
        }

        }




});
