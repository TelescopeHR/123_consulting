jQuery(document).ready(function ($) {
	console.log("Custom JS loaded!");

	var winScroll = $(this).scrollTop();

	//Header Sticky
	function headStick(winScroll) {
		var headerOffset =
			parseInt($(".site-offer").outerHeight()) +
			parseInt($(".header-top").outerHeight());
		if (winScroll > headerOffset) {
			$(".header-main").addClass("header-sticky");
		} else {
			$(".header-main").removeClass("header-sticky");
		}
	}

	headStick(winScroll);

	//Mobile Menu Hamburger Toggle
	$(".site-menutoggle input").on("change", function (e) {
		var ifOpen = $(this).prop("checked");

		if (ifOpen) {
			$("body").addClass("overflow-hidden menu-open");
		} else {
			$("body").removeClass("overflow-hidden menu-open");
		}

		$(".header-main--mobile").slideToggle(200);
	});

	//Mobile dropdowns
	$(".menu-item-has-children .icon-angle-down").on("click", function (e) {
		$(this).next("ul").slideToggle(200);
		$(this).toggleClass("open");
	});

	//Course Toggle
	$(".curritem-head").on("click", function (e) {
		e.preventDefault();
		$(this).parents(".curriculum-item").toggleClass("open");
		$(this)
			.next(".curritem-body")
			.slideToggle("medium", function () {
				if ($(this).is(":visible")) {
					$(this).css("display", "flex");
				}
			});
	});

	//Site Collapse / Toggles
	if ($(".toggleCollapse").length > 0) {
		$(".toggleCollapse").on("click", function (e) {
			e.preventDefault();
			var getTarget =
				$(this).attr("href") !== ""
					? $(this).attr("href")
					: "slideToggle";
			$(this).toggleClass("open");
			$(getTarget).slideToggle().toggleClass("open");
		});
	}

	//Popups
	$(".close-x").on("click", function (e) {
		e.preventDefault();
		$(this)
			.parents(".popup")
			.removeClass("popup-show")
			.trigger("classChange");
		$("body").removeClass("body-popup");
	});
    
	if ($(".popup-trigger").length > 0) {
		$(".popup-trigger").on("click", function (e) {
			e.preventDefault();
			var getTarget = $(this).attr("href");
			$(getTarget).addClass("popup-show");
			$("body").addClass("body-popup");
		});

		$(".popup .popup-close").on("click", function (e) {
			e.preventDefault();
			$(this)
				.parents(".popup")
				.removeClass("popup-show")
				.trigger("classChange");
			$("body").removeClass("body-popup");
		});

		$(document).mouseup(function (e) {
			var container = $(".popup-wrapper");

			if (
				!container.is(e.target) &&
				container.has(e.target).length === 0
			) {
				$(".popup").removeClass("popup-show").trigger("classChange");
				$("body").removeClass("body-popup");
			}
		});
	}

	//Window Scroll Event
	$(window).on("scroll", function () {
		var winScroll = $(this).scrollTop();
		headStick(winScroll);
	});

	$("#global-coupon-trigger").click(function () {
		$("#coupon-offer").show();
	});
});
