<x-layouts.customer-layout>
	<section class="bg-gray-50 dark:bg-gray-900 py-16 antialiased">
		<div class="max-w-7xl mx-auto px-6">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">

				<!-- Contact Info -->
				<div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg transition-all">
					<h2 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-4">Let's Talk</h2>
					<p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
						Have questions? Feel free to contact us using the form or the details
						below.
					</p>
					<ul class="space-y-4 text-sm text-gray-700 dark:text-gray-300">
						<li class="flex items-start gap-2">
							<span class="text-xl">📍</span>
							<span><strong>Address:</strong> 123 Main Street, YourCity, Country</span>
						</li>
						<li class="flex items-start gap-2">
							<span class="text-xl">📞</span>
							<span><strong>Phone:</strong> +1 (555) 123-4567</span>
						</li>
						<li class="flex items-start gap-2">
							<span class="text-xl">✉️</span>
							<span><strong>Email:</strong> support@example.com</span>
						</li>
						<li class="flex items-start gap-2">
							<span class="text-xl">🕒</span>
							<span><strong>Hours:</strong> Mon–Fri, 9AM–6PM</span>
						</li>
					</ul>
				</div>

				<!-- Contact Form -->
				<div class="md:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg transition-all">
					<h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">Contact Us</h1>

					@if(session('success'))
					<div
						class="p-4 mb-6 text-sm text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-300 rounded-lg">
						{{ session('success') }}
					</div>
					@endif

					<form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
						@csrf

						<!-- Name -->
						<div>
							<label for="name" class="block mb-2 text-sm font-medium">Name</label>
							<input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe"
								class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
								required>
							@error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
						</div>

						<!-- Email -->
						<div>
							<label for="email" class="block mb-2 text-sm font-medium">Email</label>
							<input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email"
								class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
								required>
							@error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
						</div>

						<!-- Subject -->
						<div>
							<label for="subject" class="block mb-2 text-sm font-medium">Subject</label>
							<input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Subject"
								class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
								required>
							@error('subject') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
						</div>

						<!-- Message -->
						<div>
							<label for="message" class="block mb-2 text-sm font-medium">Message</label>
							<textarea id="message" name="message" rows="5" placeholder="Your message here"
								class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
								required>{{ old('message') }}</textarea>
							@error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
						</div>

						<!-- Submit Button -->
						<button type="submit"
							class="cursor-pointer inline-block w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
							Send Message
						</button>
					</form>
				</div>
			</div>
		</div>
	</section>
</x-layouts.customer-layout>