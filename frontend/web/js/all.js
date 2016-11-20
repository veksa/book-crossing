$(document).ready(function () {
    var list = $('#list'),
        rating = $('#rating');
    if (list.length) {
        list.DataTable({
            searching: false,
            bSort: false,
            bLengthChange: false,
            bFilter: true,
            ajax: 'http://api.book-crossing.local/v1/books',
            serverSide: true,
            processing: true,
            paging: true,
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="/book/' + data['Book-ID'] + '">' + data.ISBN + '</a>';
                    }
                },
                {data: 'Book-Title'},
                {data: 'Book-Author'},
                {data: 'Year-Of-Publication'},
                {data: 'Publisher'},
                {
                    data: 'Image-URL-S',
                    render: function (data, type, row) {
                        return '<img src="' + data + '" />';
                    }
                }
            ]
        });
    }

    if (rating.length) {
        rating.DataTable({
            searching: false,
            bSort: false,
            bLengthChange: false,
            bFilter: true,
            ajax: 'http://api.book-crossing.local/v1/country-rating/' + bookId,
            serverSide: true,
            processing: true,
            paging: true,
            columns: [
                {data: 'Country'},
                {data: 'Book-Rating'}
            ]
        });
    }
});