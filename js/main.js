
function initTagSearch(key, availableTags, cb, initialTaglist) {
    var previousValue = "";
    var taglist = initialTaglist ? initialTaglist : [];
    var searchInput = $("#" + key + "-search-input");
    var tagpos = 0;

    function converInput(s) {
        return s.normalize("NFD");
    }

    function filterTags() {
        return $.map(availableTags, function (v) {
            if (!v.toLowerCase().match(searchInput.val().toLowerCase()))
                return;
            if (taglist.indexOf(v) !== -1)
                return;
            return v;
        });
    }

    function renderTaglist() {
        $("#" + key + "-taglist-active").loadTemplate($('#active-tag-template'), $.map(taglist, function (v) {
            return { "tag": v };
        }));
        var filteredTags = filterTags();
        $("#" + key + "-taglist").loadTemplate($('#inactive-tag-template'), $.map(filteredTags, function (v, i) {
            if (i == tagpos && searchInput.val())
                return { "tag": v, style: "background-color: lightGrey;" };
            return { "tag": v };
        }).slice(0, 20));
        $("#" + key + "-taglist > span").click(function () {
            var tag = $(this).data('tag');
            var idx = taglist.indexOf(tag);
            if (idx == -1) {
                taglist.push(tag);
                searchInput.attr("data-taglist", taglist);
                if (cb)
                    cb(taglist);
            }
            console.log(taglist);
            searchInput.val("");
            renderTaglist();
        });
        $("#" + key + "-taglist-active > span").click(function () {
            var tag = $(this).data('tag');
            var idx = taglist.indexOf(tag);
            if (idx !== -1) {
                taglist.splice(idx, 1);
                searchInput.attr("data-taglist", taglist);
                if (cb)
                    cb(taglist);

            }
            console.log(taglist);
            renderTaglist();
        });
    }

    searchInput.off("keyup").keyup(function (e) {
        if (e.keyCode == 13) {
            var filteredTags = filterTags();
            searchInput.val("");
            if (!filteredTags)
                return;
            var tag = filteredTags[tagpos];
            var idx = taglist.indexOf(tag);
            if (idx == -1) {
                taglist.push(tag);
                searchInput.attr("data-taglist", taglist);
                if (cb)
                    cb(taglist);
            }
            console.log(taglist);
            renderTaglist();
            return;
        }
        if (e.keyCode == 39) {
            var filteredTags = filterTags();
            if (tagpos < filteredTags.length - 1)
                tagpos++;
        } else if (e.keyCode == 37) {
            if (tagpos > 0)
                tagpos--;
        } else {
            tagpos = 0;
        }
        var isValid = false;
        for (i in availableTags) {
            if (availableTags[i].toLowerCase().match(this.value.toLowerCase())) {
                isValid = true;
            }
        }
        if (!isValid) {
            this.value = previousValue
        } else {
            previousValue = this.value;
        }
        renderTaglist();
    });

    renderTaglist();
}

$.addTemplateFormatter("KeywordsFormatter", function (value, template) {
    var tags = value.split(" ");
    return $.map(tags, function (v) {
        return '<span class="badge badge-primary tag-badge">' + v + '</span>'
    });
});

function initTab(key, availableTags) {
    initTagSearch(key, availableTags, async function (taglist) {
        var baseLat = localStorage.getItem("baseLat");
        var baseLng = localStorage.getItem("baseLng");
        baseLat = baseLat ? baseLat : 47.4811277;
        baseLng = baseLng ? baseLng : 18.9898783;
        var searchOffset = 0;

        $('#' + key + "-paginator > .nextButton").off().click(function () {
            searchOffset += 5;
            doSearch();
        });

        $('#' + key + "-paginator > .prevButton").off().click(function () {
            searchOffset -= 5;
            doSearch();
        });

        async function doSearch() {
            var data = [];
            if (taglist && taglist.length > 0) {
                data = await $.post(BACKEND_URL + "/search", {
                    taglist: taglist,
                    lat: baseLat,
                    lng: baseLng,
                    offset: searchOffset
                });
            }
            console.log(data);
            if (data.length > 5) {
                data.pop();
                $('#' + key + "-paginator > .nextButton").show();
            } else {
                $('#' + key + "-paginator > .nextButton").hide();
            }
            if (searchOffset > 0) {
                $('#' + key + "-paginator > .prevButton").show();
            } else {
                $('#' + key + "-paginator > .prevButton").hide();
            }
            $('#' + key + "-results").loadTemplate($("#result-card-template"), $.map(data, function (v) {
                if (!v.photoUrl)
                    v.photoUrl = "img/profile.jpg";
                return v;
            }));
            $(".result-card").click(function () {
                var url = $(this).attr('data-url');
                if (url) {
                    var win = window.open(url, '_blank');
                    win.focus();
                }
            });
        }

        doSearch();
    })
}
