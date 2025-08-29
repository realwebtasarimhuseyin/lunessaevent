document.addEventListener("DOMContentLoaded", function () {
    // Date variable
    var newDate = new Date();

    /**
     *
     * @getDynamicMonth() fn. is used to validate 2 digit number and act accordingly
     *
     */
    function getDynamicMonth() {
        getMonthValue = newDate.getMonth();
        _getUpdatedMonthValue = getMonthValue + 1;
        if (_getUpdatedMonthValue < 10) {
            return `0${_getUpdatedMonthValue}`;
        } else {
            return `${_getUpdatedMonthValue}`;
        }
    }

    var calendarsEvents = {
        Work: "primary",
        Personal: "success",
        Important: "danger",
        Travel: "warning",
    };

    // Calendar Elements and options
    var calendarEl = document.querySelector(".calendar");

    var checkWidowWidth = function () {
        if (window.innerWidth <= 1199) {
            return true;
        } else {
            return false;
        }
    };

    var calendarHeaderToolbar = {
        left: "prev next",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    };

    var calendarEventsList = [
        {
            id: 1,
            title: "All Day Event",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-01`,
            extendedProps: { calendar: "Work" },
        },
        {
            id: 2,
            title: "Long Event",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
            end: `${newDate.getFullYear()}-${getDynamicMonth()}-10`,
            extendedProps: { calendar: "Personal" },
        },
        {
            groupId: "999",
            id: 3,
            title: "Repeating Event",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-09T16:00:00`,
            extendedProps: { calendar: "Important" },
        },
        {
            groupId: "999",
            id: 4,
            title: "Repeating Event",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-16T16:00:00`,
            extendedProps: { calendar: "Travel" },
        },
        {
            id: 5,
            title: "Conference",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-11`,
            end: `${newDate.getFullYear()}-${getDynamicMonth()}-13`,
            extendedProps: { calendar: "Work" },
        },
        {
            id: 6,
            title: "Meeting",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T10:30:00`,
            end: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:30:00`,
            extendedProps: { calendar: "Personal" },
        },
        {
            id: 7,
            title: "Lunch",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:00:00`,
            extendedProps: { calendar: "Important" },
        },
        {
            id: 8,
            title: "Meeting",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T14:30:00`,
            extendedProps: { calendar: "Travel" },
        },
        {
            id: 9,
            title: "Birthday Party",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-13T07:00:00`,
            extendedProps: { calendar: "Personal" },
        },
        {
            id: 10,
            title: "Click for Google",
            url: "http://google.com/",
            start: `${newDate.getFullYear()}-${getDynamicMonth()}-28`,
            extendedProps: { calendar: "Important" },
        },
    ];


    // Activate Calender
    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        height: checkWidowWidth() ? 900 : 1052,
        initialView: checkWidowWidth() ? "listWeek" : "dayGridMonth",
        initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
        headerToolbar: calendarHeaderToolbar,
        events: calendarEventsList,
        locales: ["tr"],
        locale: "tr",
        unselect: function () {
            console.log("unselected");
        },
       /*  customButtons: {
            addEventButton: {
                text: "Add Event",
            },
        }, */
        eventClassNames: function ({ event: calendarEvent }) {
            const getColorValue =
                calendarsEvents[calendarEvent._def.extendedProps.calendar];
            return [
                // Background Color
                "event-fc-color fc-bg-" + getColorValue,
            ];
        },

        windowResize: function (arg) {
            if (checkWidowWidth()) {
                calendar.changeView("listWeek");
                calendar.setOption("height", 900);
            } else {
                calendar.changeView("dayGridMonth");
                calendar.setOption("height", 1052);
            }
        },
    });

   

    // Calendar Renderation
    calendar.render();
    
});
