$(document).ready(function () {
  "use strict";

  // Feather icons replacement using jQuery
  feather.replace();

  // Sidebar toggle functionality
  (function () {
    var $sidebar = $('.sidebar');
    var $catSubMenu = $('.cat-sub-menu');
    var $sidebarBtns = $('.sidebar-toggle');

    $sidebarBtns.each(function () {
      $(this).on('click', function () {
        $sidebarBtns.each(function () {
          $(this).toggleClass('rotated');
        });
        $sidebar.toggleClass('hidden');
        $catSubMenu.removeClass('visible');
      });
    });
  })();

  // Category menu toggle functionality
  (function () {
    var $showCatBtns = $('.show-cat-btn');

    if ($showCatBtns.length) {
      $showCatBtns.each(function () {
        var $catSubMenu = $(this).next('.cat-sub-menu');
        $(this).on('click', function (e) {
          e.preventDefault();
          $catSubMenu.toggleClass('visible');
          $('.category__btn').toggleClass('rotated');
        });
      });
    }
  })();

  // Language switcher functionality
  (function () {
    var $showMenu = $('.lang-switcher');
    var $langMenu = $('.lang-menu');
    var $layer = $('.layer');

    if ($showMenu.length) {
      $showMenu.on('click', function () {
        $langMenu.addClass('active');
        $layer.addClass('active');
      });

      $layer.on('click', function () {
        if ($langMenu.hasClass('active')) {
          $langMenu.removeClass('active');
          $layer.removeClass('active');
        }
      });
    }
  })();

  // User dropdown functionality
  (function () {
    var $userDdBtnList = $('.dropdown-btn');
    var $userDdList = $('.users-item-dropdown');
    var $layer = $('.layer');

    $userDdBtnList.each(function () {
      $(this).on('click', function (e) {
        $layer.addClass('active');
        var $currentDropdown = $(this).next('.users-item-dropdown');

        $userDdList.each(function () {
          if ($currentDropdown.is($(this))) {
            $(this).toggleClass('active');
          } else {
            $(this).removeClass('active');
          }
        });
      });
    });

    $layer.on('click', function () {
      $userDdList.removeClass('active');
      $layer.removeClass('active');
    });
  })();

  // Dark mode toggle functionality
  (function () {
    var darkMode = localStorage.getItem('darkMode');
    var $darkModeToggle = $('.theme-switcher');

    function enableDarkMode() {
      $('body').addClass('darkmode');
      localStorage.setItem('darkMode', 'enabled');
    }

    function disableDarkMode() {
      $('body').removeClass('darkmode');
      localStorage.setItem('darkMode', null);
    }

    if (darkMode === 'enabled') {
      enableDarkMode();
    }

    if ($darkModeToggle.length) {
      $darkModeToggle.on('click', function () {
        darkMode = localStorage.getItem('darkMode');

        if (darkMode !== 'enabled') {
          enableDarkMode();
        } else {
          disableDarkMode();
        }

        updateChartData();
      });
    }
  })();

  // Select All Checkboxes functionality
  (function () {
    var $checkAll = $('.check-all');
    var $checkers = $('.check');

    if ($checkAll.length && $checkers.length) {
      $checkAll.on('change', function () {
        $checkers.each(function () {
          $(this).prop('checked', $checkAll.is(':checked'));
          $(this).closest('tr').toggleClass('active', $checkAll.is(':checked'));
        });
      });

      $checkers.each(function () {
        $(this).on('change', function () {
          $(this).closest('tr').toggleClass('active');
          var allChecked = $checkers.length === $('.check:checked').length;
          $checkAll.prop('checked', allChecked);
        });
      });
    }
  })();

  // Checked Sum functionality
  (function () {
    var $checkAll = $('.check-all');
    var $checkers = $('.check');
    var $checkedSum = $('.checked-sum');

    if ($checkedSum.length && $checkAll.length && $checkers.length) {
      $checkAll.on('change', function () {
        var totalChecked = $('.users-table .check:checked').length;
        $checkedSum.text(totalChecked);
      });

      $checkers.each(function () {
        $(this).on('change', function () {
          var totalChecked = $('.users-table .check:checked').length;
          $checkedSum.text(totalChecked);
        });
      });
    }
  })();

  // Chart functionality with jQuery
  var charts = {};
  var gridLine;
  var titleColor;

  function updateChartData() {
    var darkMode = localStorage.getItem('darkMode');
    gridLine = darkMode === 'enabled' ? '#37374F' : '#EEEEEE';
    titleColor = darkMode === 'enabled' ? '#EFF0F6' : '#171717';

    if (charts.visitors) {
      charts.visitors.options.scales.x.grid.color = gridLine;
      charts.visitors.options.plugins.title.color = titleColor;
      charts.visitors.update();
    }
  }

  // Initialize Chart.js charts
  (function () {
    var ctx = $('#myChart');
    if (ctx.length) {
      var myCanvas = ctx[0].getContext('2d');
      var myChart = new Chart(myCanvas, {
        type: 'line',
        data: {
          labels: ['Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'Last 6 months',
              data: [35, 27, 40, 15, 30, 25, 45],
              tension: 0.4,
              backgroundColor: ['rgba(95, 46, 234, 1)'],
              borderColor: ['rgba(95, 46, 234, 1)'],
              borderWidth: 2,
            },
            {
              label: 'Previous',
              data: [20, 36, 16, 45, 29, 32, 10],
              tension: 0.4,
              backgroundColor: ['rgba(75, 222, 151, 1)'],
              borderColor: ['rgba(75, 222, 151, 1)'],
              borderWidth: 2,
            },
          ],
        },
        options: {
          scales: {
            y: {
              min: 0,
              max: 100,
              ticks: { stepSize: 25 },
              grid: { display: false },
            },
            x: {
              grid: { color: gridLine },
            },
          },
          elements: { point: { radius: 2 } },
          plugins: {
            legend: {
              position: 'top',
              align: 'end',
              labels: { boxWidth: 8, boxHeight: 8, usePointStyle: true, font: { size: 12, weight: '500' } },
            },
            title: {
              display: true,
              text: ['Visitor statistics', 'Nov - July'],
              align: 'start',
              color: '#171717',
              font: { size: 16, family: 'Inter', weight: '600', lineHeight: 1.4 },
            },
          },
        },
      });
      charts.visitors = myChart;
    }
  })();
});
