<?php
$page_title = "Contact Us — Tools & Guides Data Hub";
require __DIR__.'/partials/header.php';
?>

<main class="max-w-4xl mx-auto px-4 py-10">
  <section class="bg-white rounded-2xl border border-slate-200 shadow-lg p-6 md:p-8">
    <h1 class="text-3xl font-bold mb-4">Contact Us</h1>
    <p class="text-slate-700 mb-6">
      Have any questions, suggestions or business inquiries? Fill out the form below or email us directly.
    </p>

    <form action="#" method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Name</label>
        <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" class="w-full border rounded-lg px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Message</label>
        <textarea name="message" rows="5" class="w-full border rounded-lg px-3 py-2" required></textarea>
      </div>
      <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg">Send</button>
    </form>
  </section>
</main>

<?php require __DIR__.'/partials/footer.php'; ?>
