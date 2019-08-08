( function ( mw ) {

    modernTimelineLog( 'Timeline script' );

    function modernTimelineLog( message ) {
        if( true ) { // mw.config.get( 'debug' )
            console.log( message );
        }
    }

    mw.loader.using( [ 'ext.modern.timeline' ] ).done( function () {
        modernTimelineLog( 'Loaded timeline JS' );

        for( var timelineId in window.modernTimeline ) {
            if( window.modernTimeline.hasOwnProperty( timelineId ) ) {
                modernTimelineLog( 'Initializing timeline "' + timelineId + '"' );

                var timelineJson = window.modernTimeline[timelineId];
                new TL.Timeline( timelineId, timelineJson, timelineJson.options );

                modernTimelineLog( 'Done initializing timeline "' + timelineId + '"' );
            }
        }
    } );

}( mediaWiki ) );