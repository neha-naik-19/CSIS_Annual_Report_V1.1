$(document).ready(function (e) {
    $(this).scrollTop(0);

    var url = $("#application_url").val();

    console.log("url :: ", url);

    var globalYears = "";
    var departmentStructureHtmlData = "";
    var accordion = "";

    addDepartmentAccorditon();

    function addDepartmentAccorditon() {
        var departmentData = [];
        var dataDepartmentwise = "";

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "GET",
            url: url + "/department",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                $.each(data.maxyearfordepartment_data, function (i, ob) {
                    $.each(ob, function (key, obj) {
                        departmentData.push(obj);
                    });
                });

                // var decrypted = CryptoJS.AES.decrypt(encrypted, "");

                // console.log(encrypted.toString());

                // console.log(decrypted.toString(CryptoJS.enc.Utf8));

                $.each(data.departments, function (key, value) {
                    dataDepartmentwise = $.grep(departmentData, function (v) {
                        return v.departmentID === value.id;
                    }).pop();

                    if (globalYears === "") {
                        globalYears = data.years;
                    }

                    if (dataDepartmentwise === undefined) {
                        departmentStructureHtmlData =
                            "<div class='row'>" +
                            "<div class='col-md-10 col-sm-10 colstyleundefined'>No Records</div>" +
                            "<div class='col-sm-2'>" +
                            "<div class='collink'>" +
                            "<a href='" +
                            route("publication.add", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>Add</a>" +
                            "<a href='" +
                            route("publication.edit", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>View/Edit</a>" +
                            "<a href='" +
                            route("publication.bibtex", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>BibTex</a>" +
                            "<a href='" +
                            route("publication.print", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>Print</a>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    } else {
                        // var encryptedId = CryptoJS.AES.encrypt(
                        //     value.id.toString(),
                        //     ""
                        // ).toString();

                        departmentStructureHtmlData =
                            "<div class='container'>" +
                            "<div class='row align-items-center h-100'>" +
                            "<div class='col-sm-2'>" +
                            "<div class='prevnextcontainer justify-content-center'>" +
                            "<div class='event'><img src='../image/prev.png' class='prev'></div>" +
                            "<span id='prevnextspan'>" +
                            parseInt(dataDepartmentwise.year) +
                            "</span>" +
                            "<div class='event'><img src='../image/prev.png' class='next'></div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-sm-8'>" +
                            "<div class='row'>" +
                            "<div class='col-sm-4 colstyle'>Journal</div>" +
                            "<div class='col-sm-4 colstyle' >Conference</div>" +
                            "<div class='col-sm-4 colstyle' >Last Updated</div>" +
                            "</div>" +
                            "<div class='row'>" +
                            "<div class='col-sm-4 colstyle'><p id='journal'>" +
                            dataDepartmentwise.journal +
                            "</p></div>" +
                            "<div class='col-sm-4 colstyle' ><p id='conference'>" +
                            dataDepartmentwise.conference +
                            "</p></div>" +
                            "<div class='col-sm-4 colstyle' ><p id='lastupdateddt'>" +
                            dataDepartmentwise.lastupdateddt +
                            "</p></div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-sm-2'>" +
                            "<div class='collink'>" +
                            "<a href='" +
                            route("publication.add", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>Add</a>" +
                            "<a href='" +
                            route("publication.edit", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>View/Edit</a>" +
                            "<a href='" +
                            route("publication.bibtex", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>BibTex</a>" +
                            "<a href='" +
                            route("publication.print", {
                                id: value.id,
                                dept: value.department,
                            }) +
                            "'>Print</a>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    }

                    accordion =
                        '<div class="accordion-item">' +
                        '<h2 class="accordion-header" id="flush-heading' +
                        key +
                        '">' +
                        '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target=' +
                        '"#flush-collapse' +
                        key +
                        '" aria-expanded="false" aria-controls="flush-collapse' +
                        key +
                        '">' +
                        value.department +
                        "<span id='spanDepartmentId' style='display:none;'>" +
                        value.id +
                        "</span>" +
                        "</button>" +
                        "</h2>" +
                        '<div id="flush-collapse' +
                        key +
                        '" class="accordion-collapse collapse" aria-labelledby="flush-heading' +
                        key +
                        '" data-bs-parent="#accordionFlushExample"><div class="accordion-body">' +
                        "<div class='card'>" +
                        "<div class='card-body'>" +
                        departmentStructureHtmlData;
                    "</div>" + "</div>" + "</div></div>" + "</div>";

                    $("#accordionFlushExample").append(accordion);
                });
            },
            error: function (xhr, errorType) {
                var responseTitle = $(xhr.responseText).filter("title").get(0);

                swal(
                    "Error!",
                    $(responseTitle).text() + "\n" + xhr + "\n" + errorType
                );
            },
        });
    }

    var dataDepartmentwiseyers = [];
    var globalFirstArrayLen = 0;
    let departmentId = 0;
    var globalPrevArray = [];
    var golbalNextArray = [];

    //UPDATE ACCORDATION CONTENTS YEARWISE
    function accordionDataUpdate(element, data) {
        $(element).parents(".card-body").find("#journal").text(data.journal);

        $(element)
            .parents(".card-body")
            .find("#conference")
            .text(data.conference);

        $(element)
            .parents(".card-body")
            .find("#lastupdateddt")
            .text(data.lastupdateddt);
    }

    // ACCORDATION BUTTON COLLAPSE
    $("body").on("click", ".accordion-button", function (e) {
        e.preventDefault();

        $(".next").parent(".event").removeClass("addedevent");
        $(".next").parent(".event").addClass("lastevent");

        dataDepartmentwiseyers = [];
        departmentId = 0;

        if ($(this).attr("aria-expanded") === "true") {
            departmentId = $(this).parent().find("#spanDepartmentId").text();

            dataDepartmentwiseyers = $.grep(globalYears, function (v) {
                return v.departmentID === parseInt(departmentId);
            }).slice(1, 5);

            globalFirstArrayLen = dataDepartmentwiseyers.length;

            globalPrevArray = dataDepartmentwiseyers.map((e) => e.dt);

            globalPrevArray.reverse();
        }
    });

    // PREVIOUS BUTTON CLICK
    $("body").on("click", ".prev", function (e) {
        e.preventDefault();

        if (globalPrevArray.length > 0) {
            golbalNextArray.push(
                parseInt(
                    $(this)
                        .parents(".prevnextcontainer")
                        .find("#prevnextspan")
                        .text()
                )
            );

            $(this)
                .parents(".prevnextcontainer")
                .find("#prevnextspan")
                .text(globalPrevArray.pop());

            //post department ID to homecontroller and get department details
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + "/postdepartmentid",
                data: {
                    departmentId,
                    year: parseInt(
                        $(this)
                            .parents(".prevnextcontainer")
                            .find("#prevnextspan")
                            .text()
                    ),
                },
                success: function () {},
                complete: function () {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        type: "GET",
                        url: url + "/displayDepartmentForEveryYear",
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        success: function (data) {
                            accordionDataUpdate(
                                ".prev",
                                data.departmentDataForSelectedYear[0][0]
                            );
                        },
                    });
                },

                error: function (xhr, errorType) {
                    var responseTitle = $(xhr.responseText)
                        .filter("title")
                        .get(0);

                    swal(
                        "Error!",
                        $(responseTitle).text() + "\n" + xhr + "\n" + errorType
                    );
                },
            });
            ////
        }

        if (globalPrevArray.length < globalFirstArrayLen) {
            $(".next").parent(".event").addClass("addedevent");
        }

        if (globalPrevArray.length === 0) {
            $(this).parent(".event").removeClass("addedevent");
            $(this).parent(".event").addClass("lastevent");
            $(this).parent(".event").removeClass("eventpointer");
        }
    });

    // PREVIOUS BUTTON MOUSEMOVE
    $("body").on("mousemove", ".prev", function (e) {
        e.preventDefault();

        if (
            $(this).parent(".event").css("background-color") ===
            "rgb(211, 211, 211)"
        ) {
            $(this).parent(".event").addClass("eventdefaultpointer");
        } else {
            $(this).parent(".event").addClass("eventpointer");
        }
    });

    // NEXT BUTTON CLICK
    $("body").on("click", ".next", function (e) {
        e.preventDefault();

        if (golbalNextArray.length > 0) {
            globalPrevArray.push(
                parseInt(
                    $(this)
                        .parents(".prevnextcontainer")
                        .find("#prevnextspan")
                        .text()
                )
            );

            $(this)
                .parents(".prevnextcontainer")
                .find("#prevnextspan")
                .text(golbalNextArray.pop());

            //post department ID to homecontroller and get department details
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + "/postdepartmentid",
                data: {
                    departmentId,
                    year: parseInt(
                        $(this)
                            .parents(".prevnextcontainer")
                            .find("#prevnextspan")
                            .text()
                    ),
                },
                complete: function () {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        type: "GET",
                        url: url + "/displayDepartmentForEveryYear",
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        success: function (data) {
                            accordionDataUpdate(
                                ".next",
                                data.departmentDataForSelectedYear[0][0]
                            );
                        },
                    });
                },

                error: function (xhr, errorType) {
                    var responseTitle = $(xhr.responseText)
                        .filter("title")
                        .get(0);

                    swal(
                        "Error!",
                        $(responseTitle).text() + "\n" + xhr + "\n" + errorType
                    );
                },
            });
            ////
        }

        if (golbalNextArray.length < globalFirstArrayLen) {
            $(".prev").parent(".event").addClass("addedevent");
        }

        if (golbalNextArray.length === 0) {
            $(this).parent(".event").removeClass("addedevent");
            $(this).parent(".event").addClass("lastevent");
            $(this).parent(".event").removeClass("eventpointer");
        }
    });

    // NEXT BUTTON MOUSEMOVE
    $("body").on("mousemove", ".next", function (e) {
        e.preventDefault();

        if (
            $(this).parent(".event").css("background-color") ===
            "rgb(211, 211, 211)"
        ) {
            $(this).parent(".event").addClass("eventdefaultpointer");
        } else {
            $(this).parent(".event").addClass("eventpointer");
        }
    });
});
