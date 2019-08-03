
for (var timelineId in window.modernTimeline) {
    if (window.modernTimeline.hasOwnProperty(timelineId)) {
        var timelineJson = window.modernTimeline[timelineId];
        new TL.Timeline(timelineId, timelineJson, timelineJson.options);
    }
}