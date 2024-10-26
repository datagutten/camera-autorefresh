const base_url = $('script[src$="refresh.js"]')[0].getAttribute('data-host')
jQuery(document).ready(function () {
    jQuery("img[id^='camera']").each(function (index, element) {
        const cameraId = this.id.replace('camera-', '')
        const image_url = base_url + 'index.php?camera=' + cameraId
        this.src = image_url
        jQuery.get(base_url + 'timeout.php?camera=' + cameraId, function (timeout) {
            console.log(timeout)
            setInterval(update, timeout, element, image_url)
        })
    })
});


function update(img, image_url) {
    const cameraId = img.id.replace('camera-', '')
    //jQuery.get(base_url + '?camera=' + cameraId, function () {
    console.log('refresh ' + img.id)
    img.src = image_url + "&" + (new Date()).getTime();
    //});
}