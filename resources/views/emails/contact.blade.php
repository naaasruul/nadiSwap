<html>

<head>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f7f7f7;
			color: #444;
			margin: 0;
			padding: 0;
		}

		.container {
			background-color: #fff;
			margin: 20px auto;
			padding: 20px;
			max-width: 600px;
			border-radius: 8px;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
		}

		.header {
			border-bottom: 1px solid #e0e0e0;
			margin-bottom: 20px;
		}

		.header h2 {
			margin: 0;
			color: #333;
		}

		.content p {
			margin: 10px 0;
			line-height: 1.5;
		}

		.label {
			font-weight: bold;
			color: #222;
		}

		.footer {
			border-top: 1px solid #e0e0e0;
			margin-top: 20px;
			padding-top: 10px;
			font-size: 12px;
			color: #888;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="header">
			<h2>Contact Inquiry</h2>
		</div>
		<div class="content">
			<p><span class="label">From:</span> {{ $name }} ({{ $email }})</p>
			<p><span class="label">Subject:</span> {{ $subject }}</p>
			<p><span class="label">Message:</span></p>
			<p style="white-space: pre-line;">{{ $contact_message }}</p>
		</div>
		<div class="footer">
			<p>This email was sent via the NadiSwap contact form.</p>
		</div>
	</div>
</body>

</html>