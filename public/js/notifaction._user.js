$(document).ready(function () {
    // GET Notification
    let apiKey = $('meta[name="api-key"]').attr("content");
    const idUser = $("#notification_id").val();

    function getNotificationUser() {
        $.ajax({
            headers: {
                "X-API-KEY": apiKey,
            },
            url: "/api/notification/user/unread",
            type: "GET",
            dataType: "json",
            data: {
                user_id: idUser,
            },
            success: function (response) {
                if (response.status == "success") {
                    console.log("API Response True:", response.data);
                    if (response.data.length > 0) {
                        let responseData = response.data;
                        $(".badge-notification").removeClass("d-none");
                        $(".text-qty-notif").text(responseData.length);
                        $("#notificationList").html(
                            responseData
                                .map((item, index) => {
                                    const dataIcon = {
                                        success: "check",
                                        info: "truck",
                                        danger: "times",
                                        warning: "bell",
                                    };
                                    const time = moment(
                                        item.created_at
                                    ).fromNow();
                                    return `
                                <div class="alert alert-light notification-list" role="alert" style="padding: 0.5rem 1rem; cursor: pointer;" data-id="${
                                    item.id
                                }" data-href="${item.url}">
                                  <div class="w-100 d-flex align-items-center gap-4">
                                      <div class=""
                                          style="padding: 1rem; border-radius: 9999px; border: 2px solid #229FE1; width: 48px; height: 48px; display: flex; justify-content: center; align-items: center;">
                                          <i class="fa-solid fa-${
                                              dataIcon[item.type]
                                          }" style="font-size: 24px; color: #229FE1;"></i>
                                      </div>
                                      <div class="">
                                          <span class="fw-semibold" style="font-size: 14px;">
                                              ${item.title}
                                          </span>
                                          <p class="text-body-secondary m-0" style="font-size: 14px;">
                                            ${item.content}
                                          </p>
                                          <span class="fw-semibold" style="font-size: 12px; line-height: 1.5;">
                                              ${time}
                                          </span>
                                      </div>
                                  </div>
                              </div>`;
                                })
                                .join("")
                        );
                    } else {
                        $(".badge-notification").addClass("d-none");
                        $(".text-qty-notif").text("");
                        $("#notificationList")
                            .html(`<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Data Notifikasi Kosong</p>
                </div>`);
                    }
                }
            },
            error: function (xhr, status, error) {
                $(".badge-notification").css("display", "none");
                console.error("Error get list notification:", error);
                $("#notificationList")
                    .html(`<div class="w-100 d-flex align-items-center justify-content-center">
                    <p>Data Notifikasi Kosong</p>
                </div>`);
            },
        });
    }

    $(document).on("click", "#markAllAsReadUser", function () {
        console.log("Mark All As Read");
        $.ajax({
            headers: {
                "X-API-KEY": apiKey,
            },
            url: "/api/notification/user/mark-as-read/" + idUser,
            type: "GET",
            success: function (response) {
                if (response.success) {
                    getNotificationUser();
                }
            },
        });
    });

    $(document).on("click", ".notification-list", function () {
        const id = $(this).data("id");
        const href = $(this).data("href");

        console.log("Data ID:", id);
        console.log("Data Href:", href);

        $.ajax({
            headers: {
                "X-API-KEY": apiKey,
            },
            url: "/api/notification/user/mark-read/" + id,
            type: "GET",
            success: function (response) {
                window.location.href = href;
            },
        });
    });

    getNotificationUser();
    setInterval(getNotificationUser, 60000);
});
