$(document).ready(function (e) {
    $(this).scrollTop(0);

    var url = $("#application_url").val();

    // PUBLICATION ADD SECTION ////////////////////////////////////////

    var actions = "";
    var row = "";
    if ($(".container").attr("id") !== undefined) {
        if ($(".container").attr("id").includes("add")) {
            row =
                "<tr style='display: none;'>" +
                "<td>0</td>" +
                "<td></td>" +
                "<td>" +
                "<a class='pubaddadd' title='Add' data-toggle='tooltip'><i class='material-icons'>&#xE03B;</i></a>" +
                "<a class='pubaddedit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>" +
                "<a class='pubadddelete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>" +
                "</td>" +
                "</tr>";

            $(".pubaddtable").append(row);

            actions = $(".pubaddtable td:last-child").html();
            ////
        } else if ($(".container").attr("id").includes("update")) {
            actions = $(".pubupdatetable td:last-child").html();
        } else if ($(".container").attr("id").includes("bib")) {
            actions = $(".pubbibtable td:last-child").html();
        }
    }

    $('[data-toggle="tooltip"]').tooltip();

    var validationVoilated = false;
    var category = "";
    var pub_dup_title = false;
    var pub_dup_conference = false;
    var addnew = false;

    $("#pubaddtextareatitle").keyup(function () {
        titleduplicate("pubadd");
    });

    $("#pubaddtextareanameofconference").keyup(function () {
        conferenceduplicate("pubadd");
    });

    // pubadd = next button click event
    $(".pubaddbtnnext").click(function (e) {
        e.preventDefault();

        nextbutton("pubadd");
    });

    //pubadd = Back button click event
    $(".pubaddbtnback").click(function () {
        backbutton("pubadd");
    });

    //pubadd, pubupdate, pubbib = inputdate > (date) change
    $("#pubaddinputdate, #pubupdateinputdate, #pubbibinputdate").change(
        function () {
            var replacedid = this.id.replace("input", "label");
            if ($(this).val()) {
                $("#" + replacedid).css({ color: "#2e2e2e" });
            } else {
                $("#" + replacedid).css({ color: "#ea1f25" });
            }
        }
    );

    //pubadd, pubupdate, pubbib = selectarticle > (select) change
    $(
        "#pubaddselectarticle, #pubaddselectarticle, #pubbibselectarticle"
    ).change(function () {
        var replacedid = this.id.replace("select", "label");

        if (category.includes("conference")) {
            if ($(this).val()) {
                $("#" + replacedid).css({ color: "#2e2e2e" });
            } else {
                $("#" + replacedid).css({ color: "#ea1f25" });
            }
        }
    });

    //pubadd, pubupdate, pubbib = selectauthortype > (select) change
    $(
        "#pubaddselectauthortype, #pubaddselectauthortype, #pubbibselectauthortype"
    ).change(function () {
        var replacedid = this.id.replace("select", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd = pubaddselectcategory > (select) change
    $("#pubaddselectcategory").change(function () {
        categorychange("pubadd");
    });

    //pubadd, pubupdate, pubbib = selectdemography > (select) change
    $(
        "#pubaddselectdemography, #pubupdateselectdemography, #pubbibselectdemography"
    ).change(function () {
        var replacedid = this.id.replace("select", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = selectconference > (select) change
    $(
        "#pubaddselectconference, #pubupdateselectconference, #pubbibselectconference"
    ).change(function () {
        var replacedid = this.id.replace("select", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = selectranking > (select) change
    $(
        "#pubaddselectranking, #pubupdateselectranking, #pubbibselectranking"
    ).change(function () {
        var replacedid = this.id.replace("select", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = selectbroadarea > (select) change
    $(
        "#pubaddselectbroadarea, #pubupdateselectbroadarea, #pubbibselectbroadarea"
    ).change(function () {
        var replacedid = this.id.replace("select", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = textareatitle > (textarea) change
    $(
        "#pubaddtextareatitle, #pubupdatetextareatitle, #pubbibtextareatitle"
    ).change(function () {
        var replacedid = this.id.replace("textarea", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = textareanameofconference > (textarea) change
    $(
        "#pubaddtextareanameofconference, #pubupdatetextareanameofconference, #pubbibtextareanameofconference"
    ).change(function () {
        var replacedid = this.id.replace("textarea", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = inputimpactfactor > (text) change
    $(
        "#pubaddinputimpactfactor, #pubupdateinputimpactfactor, #pubbibinputimpactfactor"
    ).change(function () {
        var replacedid = this.id.replace("input", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = inputlocation > (text) change
    $(
        "#pubaddinputlocation, #pubupdateinputlocation, #pubbibinputlocation"
    ).change(function () {
        var replacedid = this.id.replace("input", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd, pubupdate, pubbib = inputpublisher > (text) change
    $(
        "#pubaddinputpublisher, #pubupdateinputpublisher, #pubbibinputpublisher"
    ).change(function () {
        var replacedid = this.id.replace("input", "label");
        if ($(this).val()) {
            $("#" + replacedid).css({ color: "#2e2e2e" });
        } else {
            $("#" + replacedid).css({ color: "#ea1f25" });
        }
    });

    //pubadd = all checkboxes > (check) change
    $('input[type="checkbox"]').change(function () {
        if ($(this).attr("id").includes("add")) {
            checkforallcheckboxes("pubadd");
        } else if ($(this).attr("id").includes("update")) {
            checkforallcheckboxes("pubupdate");
        } else if ($(this).attr("id").includes("bib")) {
            checkforallcheckboxes("pubbib");
        }
    });

    //pubadd = Append table with add row form on add new button click
    $(".pubaddnew").click(function (e) {
        e.preventDefault();

        addnewentry("pubadd");
    });

    //pubadd, pubupdate = Add row on add button click
    $(document).on(
        "click",
        ".pubaddadd, .pubupdateadd, .pubbibadd",
        function (e) {
            e.preventDefault();

            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
            input.each(function () {
                if (!$(this).val()) {
                    $(this).addClass("error");
                    empty = true;
                } else {
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            if (!empty) {
                input.each(function () {
                    $(this).parent("td").html($(this).val());
                });

                if ($(this).attr("class").includes("addadd")) {
                    $(this)
                        .parents("tr")
                        .find(".pubaddadd, .pubaddedit")
                        .toggle();
                    $(".pubaddnew").removeAttr("disabled");
                }
                if ($(this).attr("class").includes("updateadd")) {
                    $(this)
                        .parents("tr")
                        .find(".pubupdateadd, .pubupdateedit")
                        .toggle();
                    $(".pubupdatenew").removeAttr("disabled");
                }
                if ($(this).attr("class").includes("bibadd")) {
                    $(this)
                        .parents("tr")
                        .find(".pubbibadd, .pubbibedit")
                        .toggle();
                    $(".pubbibnew").removeAttr("disabled");
                }

                addnew = false;
            }
        }
    );

    //pubadd, pubupdate = Edit row on edit button click
    $(document).on(
        "click",
        ".pubaddedit, .pubupdateedit, .pubbibedit",
        function (e) {
            e.preventDefault();

            $(this)
                .parents("tr")
                .find("td:not(:last-child)")
                .each(function () {
                    $(this).html(
                        '<input type="text" class="form-control" value="' +
                            $(this).text() +
                            '">'
                    );
                });

            if ($(this).attr("class").includes("add")) {
                $(this).parents("tr").find(".pubaddadd, .pubaddedit").toggle();
                $(".pubaddnew").attr("disabled", "disabled");
            }

            if ($(this).attr("class").includes("update")) {
                $(this)
                    .parents("tr")
                    .find(".pubupdateadd, .pubupdateedit")
                    .toggle();
                $(".pubupdatenew").attr("disabled", "disabled");
            }

            if ($(this).attr("class").includes("bib")) {
                $(this).parents("tr").find(".pubbibadd, .pubbibedit").toggle();
                $(".pubbibnew").attr("disabled", "disabled");
            }

            addnew = true;
        }
    );

    //pubadd, pubupdate, pubbib => Delete row on delete button click
    $(document).on(
        "click",
        ".pubadddelete, .pubupdatedelete, .pubbibdelete",
        function (e) {
            e.preventDefault();

            $(this).parents("tr").remove();

            $("table tbody")
                .find("tr")
                .each(function (index) {
                    $($(this).find("td")[0]).text(index);
                });

            if ($(this).attr("class").includes("addadd")) {
                $(".pubaddnew").removeAttr("disabled");
            }

            if ($(this).attr("class").includes("updateadd")) {
                $(".pubupdatenew").removeAttr("disabled");
            }

            if ($(this).attr("class").includes("bibadd")) {
                $(".pubbibnew").removeAttr("disabled");
            }

            addnew = false;

            $(this).tooltip("hide");
        }
    );

    // pubadd => check-box functionality
    $(".pubaddformcheck .form-check-input").click(function () {
        $(".pubaddformcheck .form-check-input")
            .not(this)
            .prop("checked", false);

        $("#pubaddlabeldate").text($(this).val() + " Date");
    });

    // pubadd => REFRESH FUNCTION
    function pubaddrefresh() {
        $(":input", ".pubaddform")
            .not(":button, :submit, :reset, :hidden")
            .val("")
            .prop("checked", false)
            .prop("selected", false)
            .prop("disabled", false);

        $("#pubaddtitledisplay").val("");
        $("table.pubaddtable tbody tr").not(":first").remove();

        $(".pubaddform")
            .find("label")
            .each(function () {
                $("#" + this.id).css({ color: "#2e2e2e" });
            });
    }

    // pubadd => Refresh button click
    $(".pubaddrefresh").click(function () {
        pubaddrefresh();
    });

    // pubadd => ALLOW NUMERIC AND DECIMAL
    $(".allow_numeric").on("input", function (evt) {
        // var self = $(this);
        $(this).val(
            $(this)
                .val()
                .replace(/[^0-9\.]/g, "")
        );
        if (evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });

    // pubadd => SAVE RECORDS IN DATABASE
    $(".pubaddbtnsubmit").click(function (e) {
        e.preventDefault();

        savedata("pubadd");
    });

    // PUBLICATION EDITVIEW SECTION ////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    function pubeditviewrefresh() {
        $(".pubeditviewcard")
            .find("input[type=text]")
            .each(function () {
                if (this.id === "pubeditviewdate") {
                    $("#" + this.id).val(new Date().getFullYear());
                } else {
                    $("#" + this.id).val("");
                }
            });

        $(".pubeditviewcard")
            .find("input[type=checkbox]")
            .each(function () {
                if (
                    this.id === "pubeditviewchecksubmitted" ||
                    this.id === "pubeditviewcheckaccepted" ||
                    this.id === "pubeditviewcheckpublished"
                ) {
                    $("#" + this.id).prop("checked", true);
                } else {
                    $("#" + this.id).prop("checked", false);
                }
            });

        $(".pubeditviewcard")
            .find("select")
            .each(function () {
                $("#" + this.id).prop("selectedIndex", 0);
            });

        $(".pubeditviewcard")
            .find("textarea")
            .each(function () {
                $("#" + this.id).val("");
            });

        $("table.pubeditviewtable tbody tr").remove();
    }

    // pubeditview, pubprintdate => DATEPICKER
    $("#pubeditviewdate, #pubprintdate").datepicker({
        minViewMode: 2,
        autoclose: true,
        todayHighlight: true,
        format: "yyyy",
    });

    pubeditviewrefresh();

    // pubeditview => REFRESH FUNCTION PUBLICATION EDIT-VIEW
    $(".pubeditviewrefresh").click(function () {
        pubeditviewrefresh();
    });

    // pubeditview => AUTHOR SEARCH KEYUP IN INPUT TYPE TEXT
    $("#pubeditviewinputauthorsearch").keyup(function () {
        var query = $(this).val();

        if (query != "") {
            fetch_author_data(query);
        } else {
            $("table.pubeditviewtable tbody tr").remove();
        }
    });

    // pubeditview => fetch_author_data FOR MULIPLE AUTHOR SELECTION
    function fetch_author_data(query = "") {
        if (query != "") {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "GET",
                url: url + "/editviewauthorsearch",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                data: { query: query },
                success: function (data) {
                    $("tbody").html("");
                    if (data.table_data == undefined) {
                        $(".pubeditviewtable tr tbody").remove();
                    } else {
                        $(".pubeditviewtable tbody").html(data.table_data);
                    }
                },
                error: function (xhr, errorType) {
                    var responseTitle = $(xhr.responseText)
                        .filter("title")
                        .get(0);

                    swal("Error!", $(responseTitle).text() + "\n" + xhr);
                },
            });
        }
    }

    // pubeditview => SELECT/DESELECT CHECKBOXES IN AUTHOR TABLE
    $("#selectall").click(function () {
        if ($("table.pubeditviewtable tbody tr").length > 0) {
            var checkbox = $(
                'table.pubeditviewtable tbody input[type="checkbox"]'
            );

            console.log("test 44 :- ", this.checked);

            if (this.checked) {
                checkbox.each(function () {
                    this.checked = true;
                });
            } else {
                checkbox.each(function () {
                    this.checked = false;
                });
            }
        }
    });

    // pubeditview => SELECT ALL OR NOT IN AUTHOR SEARCH
    $("body").on(
        "click",
        'table.pubeditviewtable tbody input[type="checkbox"]',
        function () {
            if (!this.checked) {
                $("#selectall").prop("checked", false);
            }
        }
    );

    // pubeditview => SEARCH BUTTON CLICK
    $(".pubeditviewbtnsearch").click(function (e) {
        e.preventDefault();
        search_data();
    });

    // pubeditview => SEARCH FUNCTION
    function search_data() {
        var dt = $("#pubeditviewdate").val();
        var authortype = $("#pubeditviewselectauthortype").val();
        var categoryeditview = $("#pubeditviewselectcategory").val();
        var nationality = $("#pubeditviewselectdemography").val();
        var title = $("#pubeditviewtextareatitle").val();
        var conference = $("#pubeditviewtextareanameofconference").val();
        var submitted = $("#pubeditviewchecksubmitted").is(":checked");
        var accepted = $("#pubeditviewcheckaccepted").is(":checked");
        var published = $("#pubeditviewcheckpublished").is(":checked");

        var objcheck = {};
        var arrRankingData = [];
        $(
            'main.pubeditview .select-field-ranking .pubeditviewdivul ul li input[type="checkbox"]'
        ).each(function () {
            if ($(this).is(":checked")) {
                objcheck = {
                    checked: $(this).val(),
                };

                arrRankingData.push(objcheck);
            }
        });

        var objselect = {};
        var arrAuthor = [];
        $('table.pubeditviewtable tbody input[type="checkbox"]').each(
            function () {
                if ($(this).is(":checked")) {
                    objselect = {
                        fullname: $(this).closest("tr").find("td:eq(1)").html(),
                    };

                    arrAuthor.push(objselect);
                }
            }
        );

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            dataType: "text",
            url: url + "/displaysearch",
            data: {
                dt: dt,
                authortype: authortype != "0" ? authortype : null,
                category: categoryeditview != "0" ? categoryeditview : null,
                nationality: nationality != "0" ? nationality : null,
                submitted: submitted,
                accepted: accepted,
                published: published,
                title: title != "" ? title : null,
                conference: conference != "" ? conference : null,
                ranking: arrRankingData.length > 0 ? arrRankingData : null,
                author: arrAuthor.length > 0 ? arrAuthor : null,
            },
            success: function (data) {
                // console.log(JSON.parse(data));
                // if (JSON.parse(data).searchresult.length === 0) {

                if (data === "") {
                    $(".pubeditviewspan").removeClass("opacitydeactivate");
                    $(".pubeditviewspan").addClass("opacityactivate");
                } else {
                    $(".pubeditviewspan").removeClass("opacityactivate");
                    $(".pubeditviewspan").addClass("opacitydeactivate");
                }

                $("main.pubeditview .container .card.first").removeClass(
                    "sectionactive"
                );
                $("main.pubeditview .container .card.first").addClass(
                    "sectiondeactive"
                );
                $("main.pubeditview .container .card.second").css({
                    opacity: "1",
                    "pointer-events": "auto",
                });

                // $("table.pubeditviewtablesearchresult tbody tr").remove();
                // $.each(JSON.parse(data).searchresult, function (i, obj) {
                //     tabletr =
                //         "<tr>" +
                //         "<td style='display:none;'>" +
                //         obj.headerid +
                //         "</td>" +
                //         "<td style='display:none;'>" +
                //         obj.userid +
                //         "</td>" +
                //         "<td>" +
                //         obj.publicationdate +
                //         "</td>" +
                //         "<td style='display:none;'>" +
                //         obj.category +
                //         "</td>" +
                //         "<td>" +
                //         obj.title +
                //         "</td>" +
                //         "<td>" +
                //         obj.conf +
                //         "</td>" +
                //         "<td>" +
                //         obj.user +
                //         "</td>" +
                //         "<td id='pubeditviewlastchildtd'>" +
                //         "<a href='" +
                //         route("publication.update", {
                //             id: JSON.parse(data).departmentid,
                //             dept: JSON.parse(data).department,
                //         }) +
                //         "' class='pubeditviewview' title='View' data-toggle='tooltip' ><i class='material-icons'>&#xe8f4;</i></a>" +
                //         "<a class='pubeditviewedit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>" +
                //         "<a class='pubeditviewdelete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>" +
                //         "</td>" +
                //         "</tr>";

                //     $("table.pubeditviewtablesearchresult tbody").append(
                //         tabletr
                //     );
                // });

                $("table.pubeditviewtablesearchresult tbody").html(data);

                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType) {
                var responseTitle = $(xhr.responseText).filter("title").get(0);

                console.log(xhr.responseText);

                swal("Error!", $(responseTitle).text() + "\n" + xhr);
            },
        });
    }

    $(".pubeditviewbtnback").click(function (e) {
        e.preventDefault();

        $("main.pubeditview .container .card.first").removeClass(
            "sectiondeactive"
        );
        $("main.pubeditview .container .card.first").addClass("sectionactive");
        $("main.pubeditview .container .card.second").css({
            opacity: "0",
            "pointer-events": "none",
        });
    });

    //pubeditview = hide tooltip
    $(document).on(
        "click",
        ".pubeditviewview, .pubeditviewedit, .pubeditviewdelete",
        function (e) {
            $(this).tooltip("hide");

            if ($(this).attr("class").includes("pubeditviewview")) {
                $("main.pubeditview .container .card.first").removeClass(
                    "sectiondeactive"
                );
                $("main.pubeditview .container .card.first").addClass(
                    "sectionactive"
                );
                $("main.pubeditview .container .card.second").css({
                    opacity: "0",
                    "pointer-events": "none",
                });
            }

            if ($(this).attr("class").includes("pubeditviewedit")) {
                $("main.pubeditview .container .card.first").removeClass(
                    "sectiondeactive"
                );
                $("main.pubeditview .container .card.first").addClass(
                    "sectionactive"
                );
                $("main.pubeditview .container .card.second").css({
                    opacity: "0",
                    "pointer-events": "none",
                });
            }

            if ($(this).attr("class").includes("pubeditviewdelete")) {
                headerid = $(this).closest("tr").find("td:eq(0)").text();

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            type: "POST",
                            dataType: "json",
                            url: url + "/deletesearch/" + headerid,
                            // data: $('#searchedit-form').serialize(),
                            success: function (data) {},
                            error: function (xhr, errorType) {
                                var responseTitle = $(xhr.responseText)
                                    .filter("title")
                                    .get(0);

                                console.log(xhr.responseText);

                                swal(
                                    "Error!",
                                    $(responseTitle).text() + "\n" + xhr
                                );
                            },
                        });

                        search_data();
                    } else {
                    }
                });
            }
        }
    );

    ////////

    // PUBLICATION UPDATE SECTION ///////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    if ($("#updatetype").val() !== undefined) {
        $("header .dept a i").removeClass("opacityactivate");
        $("header .dept a i").addClass("opacitydeactivate");

        category = $("#pubupdateselectcategory option:selected")
            .text()
            .toLowerCase();

        if (
            $("#updatetype")
                .val()
                .substring(0, $("#updatetype").val().length - 1) === "Edit"
        ) {
            $(".pubupdatebtnupdate").removeClass("opacitydeactivate");
            $(".pubupdatebtnupdate").addClass("opacityactivate");
            $(".pubupdatebtnupdate").css({ background: "#ffc107" });

            var categoryval = $(
                "#pubupdateselectcategory option:selected"
            ).val();

            if (categoryval == 8) {
                $("#pubupdateinputimpactfactor").prop("disabled", true);
            } else if (categoryval == 7) {
                $("#pubupdateselectarticle").prop("disabled", true);
            }
        } else if (
            $("#updatetype")
                .val()
                .substring(0, $("#updatetype").val().length - 1) === "Delete"
        ) {
            $(".pubupdatebtnupdate").removeClass("opacityactivate");
            $(".pubupdatebtnupdate").addClass("opacitydeactivate");
        } else {
            $("form.pubupdateform :input")
                .not(":button, :submit, :reset, :hidden")
                .prop("disabled", true);

            $(".pubupdatenew").prop("disabled", "disabled");

            $(".pubupdatebtnupdate").removeClass("opacityactivate");
            $(".pubupdatebtnupdate").addClass("opacitydeactivate");
        }
    } else {
        $("header .dept a i").removeClass("opacitydeactivate");
        $("header .dept a i").addClass("opacityactivate");
    }

    //pubupdate = next button click event
    $(".pubupdatebtnnext").click(function (e) {
        e.preventDefault();

        nextbutton("pubupdate");
    });

    //pubupdate = title keyup
    $("#pubupdatetextareatitle").keyup(function () {
        titleduplicate("pubupdate");
    });

    //pubupdate = conference keyup
    $("#pubupdatetextareanameofconference").keyup(function () {
        conferenceduplicate("pubupdate");
    });

    //pubupdate = Back button click event
    $(".pubupdatebtnback").click(function () {
        backbutton("pubupdate");
    });

    //pubupdate = pubupdateselectcategory > (select) change
    $("#pubupdateselectcategory").change(function () {
        categorychange("pubupdate");
    });

    //pubupdate => Append table with add row form on add new button click
    $(".pubupdatenew").click(function (e) {
        e.preventDefault();

        addnewentry("pubupdate");
    });

    //pubupdate => check-box functionality
    $(".pubupdateformcheck .form-check-input").click(function () {
        $(".pubupdateformcheck .form-check-input")
            .not(this)
            .prop("checked", false);

        $("#pubupdatelabeldate").text($(this).val() + " Date");
    });

    // pubupdate => SAVE RECORDS IN DATABASE
    $(".pubupdatebtnupdate").click(function (e) {
        e.preventDefault();
        savedata("pubupdate");
    });

    ////////

    // PUBLICATION BIBTEX SECTION ///////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    // Also see: https://www.quirksmode.org/dom/inputfile.html

    // pubadd => REFRESH FUNCTION
    function pubbibrefresh() {
        $(".pubbiblabelnofile").css({ opacity: "" });
        $(".pubbiblabelnofile").css({
            color: "#333",
            "white-space": "nowrap",
            opacity: 0.3,
        });
        $(".pubbiblabelnofile").text("No file selected");
        $(".pubbib .file-input").removeClass(" -chosen");

        $(".pubbibfile").val("");
        $("table.pubbibsearchtable tbody tr").remove();
    }

    $(".pubbibrefresh").click(function () {
        pubbibrefresh();
    });

    var inputs = document.querySelectorAll(".pubbib .file-input");

    for (var i = 0, len = inputs.length; i < len; i++) {
        customInput(inputs[i]);
    }

    function customInput(el) {
        const fileInput = el.querySelector('[type="file"]');
        const label = el.querySelector("[data-js-label]");

        fileInput.onchange = fileInput.onmouseout = function () {
            if (!fileInput.value) return;

            var value = fileInput.value.replace(/^.*[\\\/]/, "");
            el.className += " -chosen";
            label.innerText = value;
        };
    }

    var reader = new FileReader();
    let readerdata = "";

    var fileTypes = ["bib"];

    function readURL(input) {
        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split(".").pop().toLowerCase(), //   extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1; //is extension in acceptable types

            if (isSuccess) {
                //yes
                reader.onload = function (e) {
                    if (extension === "bib") {
                        reader.result.toString();

                        var rawLog = reader.result;
                        readerdata = rawLog;
                    } else {
                        swal(
                            "",
                            "Uploded document format is not bib!",
                            "error"
                        ).then((value) => {
                            $(".pubbiblabelnofile").css({ opacity: "" });
                            $(".pubbiblabelnofile").css({
                                color: "#333",
                                "white-space": "nowrap",
                                opacity: 0.3,
                            });
                            $(".pubbiblabelnofile").text("No file selected");
                            $(".pubbib .file-input").removeClass(" -chosen");
                        });
                    }

                    dup_title = [];
                    dup_conference = [];
                    // ajax call to get data in table
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        type: "POST",
                        dataType: "text",
                        url: url + "/getfiledata",
                        data: {
                            filedata: reader.result.replace(/^.+?;base64,/, ""),
                        },
                        success: function (data) {
                            if (reader.result.length > 0) {
                                // console.log("result :: ", reader.result);
                            }
                        },
                        complete: function () {},
                        error: function (xhr, errorType, exception) {
                            console.log(xhr.responseText);
                            console.log(
                                "errorType : " +
                                    errorType +
                                    " exception : " +
                                    exception
                            );
                        },
                    });

                    readerdata = reader.result.toString();
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                swal("", "Uploded document format is not bib!", "error").then(
                    (value) => {
                        $(".pubbib .file-input").removeClass(" -chosen");
                        $(".pubbiblabelnofile").css({ opacity: "" });
                        $(".pubbiblabelnofile").css({
                            color: "#333",
                            "white-space": "nowrap",
                            opacity: 0.3,
                        });
                        $(".pubbiblabelnofile").text("No file selected");
                        $(".pubbib .file-input").removeClass(" -chosen");
                    }
                );
            }
        }
    }

    // pubbib = bib file search
    $(".pubbibfile").change(function () {
        $("table.pubbibsearchtable tbody tr").remove();
        readURL(this);
    });

    dataarr = [];
    // pubbib = bib data download click
    $(".pubbibbtndownload").click(function (e) {
        e.preventDefault();

        if ($(".pubbibfile").val().length > 0) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "GET",
                url: url + "/parsebibdata",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    ajaxdata(data);
                },
            });
        } else {
            swal("", "Please select the file!");
        }
    });

    var bibtablerow = "";
    var duplicate = 0;

    // pubbib = bib result table last column click
    $(document).on(
        "click",
        "table.pubbibsearchtable .pubbibdisplay",
        function (e) {
            e.preventDefault();
            // e.stopPropagation();
            // e.stopImmediatePropagation();

            // td 1 = place
            // td 2 = issue
            // td 3 = pages
            // td 4 = volume
            // td 5 = publication
            // td 6 = doi
            // td 7 = categoryid
            // td 8 = author
            // td 9 = checkdup
            // td 10 = slno
            // td 11 = dt
            // td 12 = category
            // td 13 = title
            // td 14 = conference

            $(this).tooltip("hide");

            if ($(this).closest("tr").find("td:eq(1)").text() !== "null") {
                $("#pubbibinputlocation").val(
                    $(this).closest("tr").find("td:eq(1)").text()
                );
            }

            if ($(this).closest("tr").find("td:eq(2)").text() !== "null") {
                $("#pubbibinputissueno").val(
                    $(this).closest("tr").find("td:eq(2)").text()
                );
            }

            if ($(this).closest("tr").find("td:eq(3)").text() !== "null") {
                $("#pubbibinputpageno").val(
                    $(this).closest("tr").find("td:eq(3)").text()
                );
            }

            if ($(this).closest("tr").find("td:eq(4)").text() !== "null") {
                $("#pubbibinputvolumeno").val(
                    $(this).closest("tr").find("td:eq(4)").text()
                );
            }

            if ($(this).closest("tr").find("td:eq(5)").text() !== "null") {
                $("#pubbibinputpublisher").val(
                    $(this).closest("tr").find("td:eq(5)").text()
                );
            }

            if ($(this).closest("tr").find("td:eq(6)").text() !== "null") {
                $("#pubbibinputdoi").val(
                    $(this).closest("tr").find("td:eq(6)").text()
                );
            }

            $("#pubbibselectcategory").val(
                $(this).closest("tr").find("td:eq(7)").text()
            );

            category = $("#pubbibselectcategory option:selected")
                .text()
                .toLowerCase();

            if ($(this).closest("tr").find("td:eq(7)").text() == 8) {
                $("#pubbibinputimpactfactor").prop("disabled", true);
            } else if ($(this).closest("tr").find("td:eq(7)").text() == 7) {
                $("#pubbibselectarticle").prop("disabled", true);
            }

            var authorarray = $(this)
                .closest("tr")
                .find("td:eq(8)")
                .text()
                .split(",");

            duplicate = $(this).closest("tr").find("td:eq(9)").text();

            var day = (
                "0" +
                new Date(
                    $(this).closest("tr").find("td:eq(11)").text()
                ).getDate()
            ).slice(-2);
            var month = (
                "0" +
                (new Date(
                    $(this).closest("tr").find("td:eq(11)").text()
                ).getMonth() +
                    1)
            ).slice(-2);

            var dt =
                new Date(
                    $(this).closest("tr").find("td:eq(11)").text()
                ).getFullYear() +
                "-" +
                month +
                "-" +
                day;

            $("#pubbibinputdate").val(dt);

            if ($(this).closest("tr").find("td:eq(13)").text() !== "null") {
                $("#pubbibtextareatitle").val(
                    $(this).closest("tr").find("td:eq(13)").text()
                );
            }

            if ($(this).closest("tr").find("td:eq(14)").text() !== "null") {
                $("#pubbibtextareanameofconference").val(
                    $(this).closest("tr").find("td:eq(14)").text()
                );
            }

            $("table.pubbibtable tbody tr").find("tr:gt(0)").remove();
            $.each(authorarray, function (i, obj) {
                bibtablerow =
                    "<tr><td>" +
                    (i + 1) +
                    "</td><td>" +
                    obj +
                    "</td>" +
                    "<td>" +
                    "<a class='pubbibadd' title='Add' data-toggle='tooltip'><i class='material-icons'>&#xE03B;</i></a>" +
                    "<a class='pubbibedit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>" +
                    "<a class='pubbibdelete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>" +
                    "</td>" +
                    "</tr>";

                $("table.pubbibtable tbody").append(bibtablerow);
            });

            $("main.pubbib .container form .card.bibcard").removeClass(
                "sectionactive"
            );
            $("main.pubbib .container form .card.bibcard").addClass(
                "sectiondeactive"
            );

            $("main.pubbib .container form .card.first").css({
                opacity: "1",
                "pointer-events": "auto",
            });

            $("table.pubbibsearchtable tbody tr").remove();
        }
    );

    // // pubbib = bib result table last column click
    // $(document).on(
    //     "mouseenter",
    //     "table.pubbibsearchtable .pubbibdisplay",
    //     function (e) {
    //         if (
    //             $(this).closest("tr").find("td:eq(15)").css("color") ===
    //             "rgb(33, 37, 41)"
    //         ) {
    //             $(this)
    //                 .closest("tr")
    //                 .find("td:eq(15)")
    //                 .removeClass("noduplicate");

    //             $(this).closest("tr").find("td:eq(15)").addClass("duplicate");
    //         }
    //     }
    // );

    // pubbib = bib search page back button
    $(".pubbibbtnbibback").click(function (e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "GET",
            url: url + "/parsebibdata",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                ajaxdata(data);
            },
        });

        $("main.pubbib .container form .card.bibcard").removeClass(
            "sectiondeactive"
        );
        $("main.pubbib .container form .card.bibcard").addClass(
            "sectionactive"
        );
        $("main.pubbib .container form .card.first").css({
            opacity: "0",
            "pointer-events": "none",
        });
    });

    // pubbib = next button click event
    $(".pubbibbtnnext").click(function (e) {
        e.preventDefault();

        nextbutton("pubbib");
    });

    //pubbib = title keyup
    $("#pubbibtextareatitle").keyup(function () {
        if (parseInt(duplicate) > 0) {
            duplicate = 0;
        }

        titleduplicate("pubbib");
    });

    //pubbib = conference keyup
    $("#pubbibtextareanameofconference").keyup(function () {
        if (parseInt(duplicate) > 0) {
            duplicate = 0;
        }

        conferenceduplicate("pubbib");
    });

    //pubupdate = Back button click event
    $(".pubbibbtnback").click(function () {
        backbutton("pubbib");
    });

    //pubupdate = pubupdateselectcategory > (select) change
    $("#pubbibselectcategory").change(function () {
        categorychange("pubbib");
    });

    //pubupdate => Append table with add row form on add new button click
    $(".pubbibnew").click(function (e) {
        e.preventDefault();

        addnewentry("pubbib");
        ajaxdata(data);
    });

    // pubbib => check-box functionality
    $(".pubbibformcheck .form-check-input").click(function () {
        $(".pubbibformcheck .form-check-input")
            .not(this)
            .prop("checked", false);

        $("#pubbiblabeldate").text($(this).val() + " Date");
    });

    // pubbib => SAVE RECORDS IN DATABASE
    $(".pubbibbtnsubmit").click(function (e) {
        e.preventDefault();

        savedata("pubbib");
    });

    //pubib = ajaxcall to data for download and back button
    function ajaxdata(data) {
        $("table.pubbibsearchtable tbody tr").remove();

        var tabletr = "";
        var items = "";
        var displayitem = "";
        var checkdup = 0;
        var duplicatedisplay = "";

        dataarr.push(data);

        $.each(data, function (i, obj) {
            items = "";

            if (obj.duplicatetitle.length > 0 || obj.duplicateconf.length > 0) {
                displayitem =
                    "<a class='duplicate' title='Display' data-toggle='tooltip'><i class='material-icons'>&#xe5cd;</i></a>";
            } else {
                displayitem =
                    "<a class='pubbibdisplay noduplicate' title='Display' data-toggle='tooltip'><i class='material-icons'>&#xe409;</i></a>";
            }

            // only title duplicate = 1
            if (
                obj.duplicatetitle.length > 0 &&
                obj.duplicateconf.length === 0
            ) {
                checkdup = 1;
                duplicatedisplay =
                    '<div class="col-6 duplicate"><p>Title already exist.</p></div></div>';
            }

            // only conference duplicate = 2
            if (
                obj.duplicatetitle.length === 0 &&
                obj.duplicateconf.length > 0
            ) {
                checkdup = 2;
                duplicatedisplay =
                    '<div class="col-6 duplicate"><p>Conference already exist.</p></div></div>';
            }

            // title & conference duplicate = 3
            if (obj.duplicatetitle.length > 0 && obj.duplicateconf.length > 0) {
                checkdup = 3;
                duplicatedisplay =
                    '<div class="col-6 duplicate"><p>Tile and Conference already exist.</p></div></div>';
            }

            if (obj.place !== null) {
                items =
                    '<div class="row g-0"><div class="col-2 internalcol"><p>Place : </p></div><div class="col-6 internalcol">' +
                    "<p>" +
                    obj.place +
                    "</p>" +
                    "</div></div>";
            }
            if (obj.issue !== null) {
                items =
                    items +
                    '<div class="row g-0"><div class="col-2 internalcol"><p>Issue : </p></div><div class="col-6 internalcol">' +
                    "<p>" +
                    obj.issue +
                    "</p>" +
                    "</div></div>";
            }
            if (obj.pages !== null) {
                items =
                    items +
                    '<div class="row g-0"><div class="col-2 internalcol"><p>Pages : </p></div><div class="col-6 internalcol">' +
                    "<p>" +
                    obj.pages +
                    "</p>" +
                    "</div></div>";
            }
            if (obj.volume !== null) {
                items =
                    items +
                    '<div class="row g-0"><div class="col-2 internalcol"><p>Volume : </p></div><div class="col-6 internalcol">' +
                    "<p>" +
                    obj.volume +
                    "</p>" +
                    "</div></div>";
            }
            if (obj.publisher !== null) {
                items =
                    items +
                    '<div class="row g-0"><div class="col-2 internalcol"><p>Publisher : </p></div><div class="col-6 internalcol">' +
                    "<p>" +
                    obj.publisher +
                    "</p>" +
                    "</div></div>";
            }
            if (obj.doi !== null) {
                items =
                    items +
                    '<div class="row g-0"><div class="col-2 internalcol"><p>DOI : </p></div><div class="col-6 internalcol">' +
                    "<p>" +
                    obj.doi +
                    "</p>" +
                    "</div></div>";
            }

            tabletr =
                '<tr class="accordion-toggle collapsed" id="accordion' +
                i +
                '" data-bs-toggle="collapse" data-bs-parent="#accordion' +
                i +
                '" href="#collapse' +
                i +
                '" aria-controls="collapse' +
                i +
                '">' +
                '<td class="expand-button"></td>' +
                "<td style='display: none;'>" +
                obj.place +
                "</td>" +
                "<td style='display: none;'>" +
                obj.issue +
                "</td>" +
                "<td style='display: none;'>" +
                obj.pages +
                "</td>" +
                "<td style='display: none;'>" +
                obj.volume +
                "</td>" +
                "<td style='display: none;'>" +
                obj.publisher +
                "</td>" +
                "<td style='display: none;'>" +
                obj.doi +
                "</td>" +
                "<td style='display: none;'>" +
                obj.categoryid +
                "</td>" +
                "<td style='display: none;'>" +
                obj.author +
                "</td>" +
                "<td style='display: none;'>" +
                checkdup +
                "</td>" +
                "<td>" +
                (i + 1) +
                "</td>" +
                "<td>" +
                obj.dt +
                "</td>" +
                "<td>" +
                obj.category +
                "</td>" +
                "<td>" +
                obj.title +
                "</td>" +
                "<td>" +
                obj.conf +
                "</td>" +
                "<td>" +
                displayitem +
                "</td>" +
                "</tr>" +
                '<tr class="hide-table-padding">' +
                "<td></td>" +
                '<td colspan="4">' +
                '<div id="collapse' +
                i +
                '" class="collapse in p-3">' +
                items +
                '<div class="row g-0"><div class="col-2 internalcol internalcol">Authors : </div><div class="col-10 internalcol">' +
                obj.author +
                duplicatedisplay +
                "</div></div>" +
                "</div>" +
                "</td>" +
                "</tr>";

            $("table.pubbibsearchtable tbody").append(tabletr);

            $('[data-toggle="tooltip"]').tooltip();
        });
    }

    ////////

    // PUBLICATION PRINT SECTION ////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    function pubprintrefresh() {
        $(".pubprintcard")
            .find("input[type=text]")
            .each(function () {
                if (this.id === "pubprintdate") {
                    $("#" + this.id).val(new Date().getFullYear());
                } else {
                    $("#" + this.id).val("");
                }
            });

        $(".pubprintcard")
            .find("input[type=checkbox]")
            .each(function () {
                if (
                    this.id === "pubprintchecksubmitted" ||
                    this.id === "pubprintcheckaccepted" ||
                    this.id === "pubprintcheckpublished"
                ) {
                    $("#" + this.id).prop("checked", true);
                } else {
                    $("#" + this.id).prop("checked", false);
                }
            });

        $(".pubprintcard")
            .find("select")
            .each(function () {
                $("#" + this.id).prop("selectedIndex", 0);
            });

        $(".pubprintcard")
            .find("textarea")
            .each(function () {
                $("#" + this.id).val("");
            });

        $("table.pubprinttable tbody tr").remove();
    }

    pubprintrefresh();

    $(".pubprintrefresh").click(function () {
        pubprintrefresh();
    });

    // pubprint => SELECT/DESELECT CHECKBOXES IN AUTHOR TABLE
    $("#selectallprint").click(function () {
        if ($("table.pubprinttable tbody tr").length > 0) {
            var checkbox = $(
                'table.pubprinttable tbody input[type="checkbox"]'
            );

            if (this.checked) {
                checkbox.each(function () {
                    this.checked = true;
                });
            } else {
                checkbox.each(function () {
                    this.checked = false;
                });
            }
        }
    });

    // // pubprint => SELECT ALL OR NOT IN AUTHOR SEARCH
    $("body").on(
        "click",
        'table.pubprinttable tbody input[type="checkbox"]',
        function () {
            if (!this.checked) {
                $("#selectallprint").prop("checked", false);
            }
        }
    );

    // pubprint => AUTHOR SEARCH KEYUP IN INPUT TYPE TEXT
    $("#pubprintinputauthorsearch").keyup(function () {
        var query = $(this).val();

        if (query != "") {
            fetch_author_data_print(query);
        } else {
            $("table.pubprinttable tbody tr").remove();
        }
    });

    // pubprint => fetch_author_data FOR MULIPLE AUTHOR SELECTION
    function fetch_author_data_print(query = "") {
        if (query != "") {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "GET",
                url: url + "/printauthorsearch",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                data: { query: query },
                success: function (data) {
                    $("tbody").html("");
                    if (data.table_data == undefined) {
                        $(".pubprinttable tr tbody").remove();
                    } else {
                        $(".pubprinttable tbody").html(data.table_data);
                    }
                },
                error: function (xhr, errorType) {
                    var responseTitle = $(xhr.responseText)
                        .filter("title")
                        .get(0);

                    swal("Error!", $(responseTitle).text() + "\n" + xhr);
                },
            });
        }
    }

    // pubprint => PRINT CLICK EVENT
    $(".pubprintbtnprint").click(function () {
        printformrequest();
    });

    // pubprint => PRINT REQUEST FUNCTION
    function printformrequest() {
        var dt = $("#pubprintdate").val();
        var authortype = $("#pubprintselectauthortype").val();
        var categoryprint = $("#pubprintselectcategory").val();
        var nationality = $("#pubprintselectdemography").val();
        var title = $("#pubprinttextareatitle").val();
        var conference = $("#pubprinttextareanameofconference").val();
        var submitted = $("#pubprintchecksubmitted").is(":checked");
        var accepted = $("#pubprintcheckaccepted").is(":checked");
        var published = $("#pubprintcheckpublished").is(":checked");

        var objcheck = {};
        var arrRankingData = [];
        $(
            'main.pubprint .select-field-ranking .pubprintdivul ul li input[type="checkbox"]'
        ).each(function () {
            if ($(this).is(":checked")) {
                objcheck = {
                    checked: $(this).val(),
                };

                arrRankingData.push(objcheck);
            }
        });

        var objselect = {};
        var arrAuthor = [];
        $('table.pubprinttable tbody input[type="checkbox"]').each(function () {
            if ($(this).is(":checked")) {
                objselect = {
                    fullname: $(this).closest("tr").find("td:eq(1)").html(),
                };

                arrAuthor.push(objselect);
            }
        });

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            dataType: "text",
            url: url + "/printrequest",
            data: {
                dt: dt,
                authortype: authortype != "0" ? authortype : null,
                category: categoryprint != "0" ? categoryprint : null,
                nationality: nationality != "0" ? nationality : null,
                submitted: submitted,
                accepted: accepted,
                published: published,
                title: title != "" ? title : null,
                conference: conference != "" ? conference : null,
                ranking: arrRankingData.length > 0 ? arrRankingData : null,
                author: arrAuthor.length > 0 ? arrAuthor : null,
            },
            success: function (data) {
                console.log(data);

                // console.log(JSON.parse(data));
                // if (JSON.parse(data).searchresult.length === 0) {
                // if (data === "") {
                //     $(".pubeditviewspan").removeClass("opacitydeactivate");
                //     $(".pubeditviewspan").addClass("opacityactivate");
                // } else {
                //     $(".pubeditviewspan").removeClass("opacityactivate");
                //     $(".pubeditviewspan").addClass("opacitydeactivate");
                // }
                // $("main.pubeditview .container .card.first").removeClass(
                //     "sectionactive"
                // );
                // $("main.pubeditview .container .card.first").addClass(
                //     "sectiondeactive"
                // );
                // $("main.pubeditview .container .card.second").css({
                //     opacity: "1",
                //     "pointer-events": "auto",
                // });
                // $("table.pubeditviewtablesearchresult tbody").html(data);
                // $('[data-toggle="tooltip"]').tooltip();
            },
            error: function (xhr, errorType) {
                var responseTitle = $(xhr.responseText).filter("title").get(0);

                console.log(xhr.responseText);

                swal("Error!", $(responseTitle).text() + "\n" + xhr);
            },
        });
    }

    ////////

    // LOGIN SECTION ////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    //alert(url);

    ////////

    ////////////////////////////////////////////////////////////////////////
    ////////// Common functions //////////

    // NEXT BUTTON
    function nextbutton(element) {
        validationVoilated = false;

        // INPUT VALIDATION
        $("." + element + "form")
            .find("input")
            .each(function () {
                if (
                    this.id !== element + "inputvolumeno" &&
                    this.id !== element + "inputissueno" &&
                    this.id !== element + "inputpageno" &&
                    this.id !== element + "inputdoi"
                ) {
                    if (!$(this).val()) {
                        if (category.includes("conference")) {
                            if (this.id !== element + "inputimpactfactor") {
                                var replacedid = this.id.replace(
                                    "input",
                                    "label"
                                );
                                $("#" + replacedid).css({ color: "#ea1f25" });
                            }
                        } else {
                            var replacedid = this.id.replace("input", "label");
                            $("#" + replacedid).css({ color: "#ea1f25" });
                        }
                    }
                }
            });

        //TEXTAREA VALIDATION
        $("." + element + "form")
            .find("textarea")
            .each(function () {
                if (!$(this).val()) {
                    var replacedid = this.id.replace("textarea", "label");
                    $("#" + replacedid).css({ color: "#ea1f25" });
                }
            });

        //SELECT VALIDATION
        // if (element != "pubupdate") {
        $("." + element + "form")
            .find("select")
            .each(function () {
                if (
                    $("#" + this.id)
                        .find(":selected")
                        .text() === ""
                ) {
                    if (category.includes("journal")) {
                        if (this.id !== element + "selectarticle") {
                            var replacedid = this.id.replace("select", "label");
                            $("#" + replacedid).css({ color: "#ea1f25" });
                        }
                    } else {
                        var replacedid = this.id.replace("select", "label");
                        $("#" + replacedid).css({ color: "#ea1f25" });
                    }
                }
            });
        // }

        //CHECKBOX VALIDATION
        var checked = false;
        $("." + element + "form")
            .find('input[type="checkbox"]')
            .each(function () {
                if ($(this).is(":checked") == false) {
                    checked = false;
                } else {
                    checked = true;
                    return false;
                }
            });

        if (checked) {
            $("." + element + "form")
                .find('input[type="checkbox"]')
                .each(function () {
                    var replacedid = this.id.replace("check", "label");
                    $("#" + replacedid).css({ color: "#2e2e2e" });
                });
        } else {
            $("." + element + "form")
                .find('input[type="checkbox"]')
                .each(function () {
                    var replacedid = this.id.replace("check", "label");
                    $("#" + replacedid).css({ color: "#ea1f25" });
                });
        }

        //LABEL COLOR CHANGING PROCESS
        $("." + element + "form")
            .find("label")
            .each(function () {
                if ($("#" + this.id).css("color") === "rgb(234, 31, 37)") {
                    validationVoilated = true;
                    return false;
                }
            });

        if (!validationVoilated) {
            var validateduplicate = false;

            if (pub_dup_title && pub_dup_conference) {
                validateduplicate = true;
                swal("Please Check!", "Title and Conference already exist!");
            } else if (pub_dup_title && !pub_dup_conference) {
                validateduplicate = true;
                swal("Please Check!", "Title  already exist!");
            } else if (!pub_dup_title && pub_dup_conference) {
                validateduplicate = true;
                swal("Please Check!", "Conference  already exist!");
            }

            if (!validateduplicate) {
                $(
                    "main." + element + " .container form .card.first"
                ).removeClass("sectionactive");
                $("main." + element + " .container form .card.first").addClass(
                    "sectiondeactive"
                );

                $("main." + element + " .container form .card.second").css({
                    opacity: "1",
                    "pointer-events": "auto",
                });

                $("#" + element + "titledisplay").append(
                    $.trim($("#" + element + "textareatitle").val())
                );
            }
        }
    }

    // TITLE DUPLICATE
    function titleduplicate(element) {
        pub_dup_title = "123";

        var title = $("#" + element + "textareatitle");

        //DUPLICATE TITLE CHECK
        if (title.val() != "") {
            var weburl = "";

            if (element.includes("add")) {
                weburl = "/check_title_duplication";
            } else if (element.includes("update")) {
                weburl = "/check_title_duplication_update";
            } else if (element.includes("bib")) {
                weburl = "/check_title_duplication_bib";
            }

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + "/gettitle",
                data: { duptitle: title.val() },
                success: function () {},
                complete: function () {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        type: "GET",
                        url: url + weburl,
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        success: function (data) {
                            // console.log("data :- ", data);
                            if (data.length > 0) {
                                pub_dup_title = true;
                            } else {
                                pub_dup_title = false;
                            }
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
        }
    }

    // CONFERENCE DUPLICATE
    function conferenceduplicate(element) {
        pub_dup_conference = "";

        var conference = $("#" + element + "textareanameofconference");

        //DUPLICATE CONFERENCE CHECK
        if (conference.val() != "") {
            var weburl = "";

            if (element.includes("add")) {
                weburl = "/check_conference_duplication";
            } else if (element.includes("update")) {
                weburl = "/check_conference_duplication_update";
            } else if (element.includes("bib")) {
                weburl = "/check_conference_duplication_bib";
            }

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + "/getconference",
                data: {
                    duptitle: conference.val(),
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
                        url: url + weburl,
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        success: function (data) {
                            if (data.length > 0) {
                                pub_dup_conference = true;
                            } else {
                                pub_dup_conference = false;
                            }
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
        }
    }

    // BACK BUTTON
    function backbutton(element) {
        $("main." + element + " .container form .card.first").removeClass(
            "sectiondeactive"
        );
        $("main." + element + " .container form .card.first").addClass(
            "sectionactive"
        );
        $("main." + element + " .container form .card.second").css({
            opacity: "0",
            "pointer-events": "none",
        });
    }

    // CATEGORY CHANGE
    function categorychange(element) {
        // 1 - Conference
        // 2 - Journal

        category = $("#" + element + "selectcategory option:selected")
            .text()
            .toLowerCase();

        if (category.length > 0) {
            $("#" + element + "labelcategory").css({ color: "#2e2e2e" });
        }

        if (category.includes("conference")) {
            $("#" + element + "inputimpactfactor").prop("disabled", "disabled");
            $("#" + element + "inputimpactfactor").val("");
            $("#" + element + "selectarticle").removeAttr("disabled");

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "GET",
                url: url + "/showarticle",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    $("#" + element + "selectarticle").empty();

                    $("#" + element + "selectarticle").append(
                        '<option value="0" selected></option>'
                    );
                    $.each(data, function (key, value) {
                        $("#" + element + "selectarticle").append(
                            '<option value="' +
                                value.articleid +
                                '">' +
                                value.article +
                                "</option>"
                        );
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
            $("#" + element + "labelimpactfactor").css({ color: "#2e2e2e" });
        } else {
            $("#" + element + "inputimpactfactor").removeAttr("disabled");
            $("#" + element + "selectarticle").prop("disabled", "disabled");
            $("#" + element + "selectarticle").empty();
            $("#" + element + "selectarticle").append(
                '<option value="0" selected></option>'
            );

            $("#" + element + "labelarticle").css({ color: "#2e2e2e" });
        }
    }

    // CHECK FOR ALL CHECKBOXES
    function checkforallcheckboxes(element) {
        $("." + element + "form")
            .find('input[type="checkbox"]')
            .each(function () {
                if (!$(this).checked) {
                    var replacedid = this.id.replace("check", "label");
                    $("#" + replacedid).css({ color: "#2e2e2e" });
                }
            });
    }

    // ADD NEW
    function addnewentry(element) {
        $(this).attr("disabled", "disabled");
        var index = $("." + element + "table tbody tr:last-child").index();
        var row =
            "<tr>" +
            "<td name='slno'>" +
            (parseInt($("table." + element + "table tr:last td:first").text()) +
                1) +
            "</td>" +
            '<td name="name"><input type="text" class="form-control"  id="name"></td>' +
            "<td>" +
            actions +
            "</td>" +
            "</tr>";

        $("." + element + "table").append(row);

        $("table." + element + "table tbody tr")
            .eq(index + 1)
            .find("." + element + "add, ." + element + "edit")
            .toggle();
        $('[data-toggle="tooltip"]').tooltip();

        addnew = true;
    }

    function savedata(element) {
        if (
            $("table." + element + "table tbody tr").length - 1 === 0 ||
            addnew
        ) {
            swal("", "Please enter Author details!", "info");
        } else {
            var tableArr = [];
            var weburl = "";

            if (element.includes("add")) {
                weburl = "/writetodb";
            } else if (element.includes("update")) {
                weburl = "/updatetodb";
            } else if (element.includes("bib")) {
                weburl = "/writebibtodb";
            }

            $("table." + element + "table tbody tr")
                .not(":first")
                .each(function () {
                    tableArr.push({
                        slno: $(this).children("td").eq(0).text(),
                        name: $(this).children("td").eq(1).text(),
                    });
                });

            // var formdata = $("." + element + "form").serializeArray();
            // var data = {};
            // $(formdata).each(function (index, obj) {
            //     data[obj.name] = obj.value;
            // });

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + weburl,
                data: {
                    departmentid: $("#departmentid")
                        .val()
                        .substring(0, $("#departmentid").val().length - 1),
                    categoryid: $("#" + element + "selectcategory")
                        .find(":selected")
                        .val(),
                    authortypeid: $("#" + element + "selectauthortype")
                        .find(":selected")
                        .val(),
                    article: $("#" + element + "selectarticle")
                        .find(":selected")
                        .val(),
                    nationality: $("#" + element + "selectdemography")
                        .find(":selected")
                        .val(),
                    pubdate: $("#" + element + "inputdate").val(),
                    submitted: $("#" + element + "checksubmitted").is(
                        ":checked"
                    ),
                    accepted: $("#" + element + "checkaccepted").is(":checked"),
                    published: $("#" + element + "checkpublished").is(
                        ":checked"
                    ),
                    title: $("#" + element + "textareatitle").val(),
                    confname: $(
                        "#" + element + "textareanameofconference"
                    ).val(),
                    place: $("#" + element + "inputlocation").val(),
                    rankingid: $("#" + element + "selectranking")
                        .find(":selected")
                        .val(),
                    broadareaid: $("#" + element + "selectbroadarea")
                        .find(":selected")
                        .val(),
                    impactfactor: $("#" + element + "inputimpactfactor").val(),
                    volume: $("#" + element + "inputvolumeno").val(),
                    issue: $("#" + element + "inputissueno").val(),
                    pp: $("#" + element + "inputpageno").val(),
                    digitallibrary: $("#" + element + "inputdoi").val(),
                    publisher: $("#" + element + "inputpublisher").val(),
                    tabledata: tableArr,
                },
                success: function () {
                    if (element.includes("add")) {
                        swal("", "Record saved successfully!", "success");
                        pubaddrefresh();
                        $(
                            "main.pubadd .container form .card.first"
                        ).removeClass("sectiondeactive");
                        $("main.pubadd .container form .card.first").addClass(
                            "sectionactive"
                        );
                        $("main.pubadd .container form .card.second").css({
                            opacity: "0",
                            "pointer-events": "none",
                        });
                    } else if (element.includes("update")) {
                        swal({
                            title: "",
                            text: "Record saved successfully!",
                            icon: "success",
                        }).then(function () {
                            window.top.close();
                        });
                    } else if (element.includes("bib")) {
                        swal("", "Record saved successfully!", "success");
                        pubaddrefresh();
                        $(
                            "main.pubbib .container form .card.bibcard"
                        ).removeClass("sectiondeactive");
                        $("main.pubbib .container form .card.bibcard").addClass(
                            "sectionactive"
                        );
                        $("main.pubbib .container form .card.second").css({
                            opacity: "0",
                            "pointer-events": "none",
                        });
                        $("main.pubbib .container form .card.first").css({
                            opacity: "0",
                            "pointer-events": "none",
                        });
                    }
                },

                error: function (xhr, errorType) {
                    var responseTitle = $(xhr.responseText)
                        .filter("title")
                        .get(0);

                    swal("Error!", $(responseTitle).text() + "\n" + xhr);
                },
            });
        }
    }

    ////////// Common functions //////////
});
