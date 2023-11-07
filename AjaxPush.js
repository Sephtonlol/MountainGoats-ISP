AjaxPush = function(listener, sender)
{
	this.listener = listener || "";
	this.sender = sender || "";
	this.state = false;
	this.timestamp = 0;
}

AjaxPush.prototype =
{
	connect: function(callback) {
		var that = this;
		var status = false;

		$.ajax({ url: this.listener, dataType: 'json',
			data: { timestamp: this.timestamp },
			success: function(data)
			{
				if (!that.state)
					console.info("Connected!");

				status = true;
				this.state = true;
				that.timestamp = data["timestamp"];
				callback(data);
			},
			complete: function(data)
			{
				// als er problemen zijn met connectie connect opnieuw
				if (!status)
				{
					console.info("The connection has been lost!, trying to reconnect ...");
					setTimeout(function(){ that.connect(callback); }, 1000);
				}
				// stuur ajax request naar server
				else
					that.connect(callback);

				that.state = (data.status == 200) ? true: false;
			}
		});
	},

	doRequest: function(data, callback) {
		$.ajax({ url: this.sender, data: data,
			success: function() { callback(); }
		});
	}
}