/**
 * FRONT-END SEAT MAP JS FUNCTIONS
 **/

/**
 * Canvas initializer.
 */
var canvas = new fabric.Canvas('venue', {
    backgroundColor: '#f8f8fa',
    containerClass: 'venue-wrapper',
    enableRetinaScaling: true,
    height: responsiveHeight() -71,
    width: responsiveWidth(),
    selection: false
});

// @TODO CHANGE THIS PART TO IMPLEMENT DRAWING
fabric.loadSVGFromURL('/img/kombank.svg', function (objects, options) {
    var obj = fabric.util.groupSVGElements(objects, options);
    canvas.add(obj).renderAll();
    canvas.setZoom(canvas.getZoom() / 1.5);
});

/**
 * Sets height and width of canvas for responsive changes.
 * @returns {jQuery}
 */
function responsiveHeight() {
    return $(window).height();
}

function responsiveWidth() {
    return $(window).width();
}

function watchResponsive() {
    var venue = $('#venue');
    $(window).resize(function () {
        $('#sidebar').height(responsiveHeight() - 71);
        venue.height(responsiveHeight());
        venue.width(responsiveWidth());
    });
}

/**
 * Sets sidebar and category wrapper heights
 * @returns {jQuery}
 */
function setSidebarHeight()
{
    return $('#sidebar').height(responsiveHeight() - 71);
}

function setCategoriesHeight()
{
    return $('#categories').height(responsiveHeight() - 71);
}

var cart = new Vue({
    el: '#sidebar',
    data: {
        items: []
    },
    computed: {
        total: function () {
            var total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += this.items[i].price;
            }

            return total;
        },
        showCart: function () {
            return this.items.length > 0;
        }
    },
    methods: {
        add: function (item) {
            this.items.push(item);
        },
        remove: function (item) {
            this.items.splice(this.items.indexOf(item), 1);
        },
        removeFromCart: function (item) {
            item.set('stroke', '#46BE8A');
            item.set('fill', '#46BE8A');
            item.set('status', '1');
            canvas.renderAll();

            this.items.splice(this.items.indexOf(item), 1);
        }
    }
});

/**
 * Draws Zones and Seats
 */
function getSeatsOf(zone) {
    axios.get('/zone/data/' + zone)
        .then(function (response) {
            drawSeats(response.data.objects);
        })
        .catch(function (error) {
            console.log(error);
        });
}

function drawSeats(objects) {
    var width = $(window).width();
    var categoriesWidth = $('#categories').width();
    var sidebarWidth = $('#sidebar').width();

    var remaining = width - (categoriesWidth + sidebarWidth);

    var leftPadding = remaining - 305;

    var seats = JSON.parse(objects);

    for (var i = 0; i < seats.objects.length; i++) {
        seats.objects[i]['left'] = seats.objects[i]['left'] + leftPadding;
    }

    canvas.loadFromJSON(seats);
    canvas.setZoom(canvas.getZoom() * 1.5);

    canvas.on('mouse:down', function (el) {
        var seat = el.target;

        if (seat.status === '1') {
            seat.set('status', '5');
            seat.set('stroke', '#89BCEB');
            seat.set('fill', '#89BCEB');
            cart.add(seat);
            canvas.renderAll();
        } else if (seat.status === '5') {
            seat.setStatus('1');
            seat.set('stroke', '#46BE8A');
            seat.set('fill', '#46BE8A');
            cart.remove(seat);
            canvas.renderAll();
        }
    })
}

/**
 * Initialize application.
 */
$(document).ready(function () {
    setSidebarHeight();
    watchResponsive();
    setCategoriesHeight();
});