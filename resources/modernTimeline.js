// TODO: ES6 compat

for (const [timelineId, timelineJson] of Object.entries(window.modernTimeline)) {
    new TL.Timeline(timelineId, timelineJson, timelineJson.options);
}