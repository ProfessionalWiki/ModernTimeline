
function modernTimelineLog( message ) {
    if( true ) { // mediaWiki.config.get( 'debug' )
        console.log( message );
    }
}

modernTimelineLog( 'Timeline script' );

for( var timelineId in window.modernTimeline ) {
    if( window.modernTimeline.hasOwnProperty( timelineId ) ) {
        modernTimelineLog( 'Initializing timeline "' + timelineId + '"' );

        var timelineJson = window.modernTimeline[timelineId];
        new TL.Timeline( timelineId, timelineJson, timelineJson.options );
    }
}