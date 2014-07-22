App.factory('Stats', function () {
  return {
    getForDashboard: function() {

        // DATES GENERATING
        var to = new Date();
        var from = new Date();
        from.setDate(from.getDate() - 14);

        var day;
        var dates = [];
        var dates_values = [];

        while(from <= to) {
            day = to.getDate();
            to = new Date(to.setDate(--day));
            var date = to.getDate()+'/'+(to.getMonth()+1)+'/'+to.getFullYear();
            dates.push(date);

            var val = Math.floor(Math.random()*301);
            dates_values.push(val);
        }

        // Big object
        var stats = {
            views : {
                web : {
                    today:Math.floor(Math.random()*100),
                    yesterday:(Math.floor(Math.random()*100)),
                    total:(Math.floor(Math.random()*2000)+2000)
                },
                pdf : {
                    today:Math.floor(Math.random()*100),
                    yesterday:(Math.floor(Math.random()*100)),
                    total:(Math.floor(Math.random()*2000)+2000)
                },
                pres : {
                    today:Math.floor(Math.random()*100),
                    yesterday:(Math.floor(Math.random()*100)),
                    total:(Math.floor(Math.random()*2000)+2000)
                },
                timeline : {
                    labels:dates,
                    data:dates_values
                }
            }
        };

        // Calculating totals
        stats.views.total = {
            today : stats.views.web.today+stats.views.pdf.today+stats.views.pres.today,
            yesterday : stats.views.web.yesterday+stats.views.pdf.yesterday+stats.views.pres.yesterday,
            total :  stats.views.web.total+stats.views.pdf.total+stats.views.pres.total
        };

        // Calculating growth
        stats.views.variations = {
            growth : Math.ceil(((stats.views.total.today-stats.views.total.yesterday)/stats.views.total.yesterday)*100),
            new_visits : stats.views.total.today-stats.views.total.yesterday
        };

        if(stats.views.variations.growth>=0)
            stats.views.variations.growth="+"+stats.views.variations.growth;

        if(stats.views.variations.new_visits>=0)
            stats.views.variations.new_visits="+"+stats.views.variations.new_visits;

        return stats;
    }
  };
});