<!-- <input type="text" id="mailSearch" class="form-control mb-2" placeholder="Search mail...">
<div id="mailList" class="flex-grow-1 overflow-auto"></div>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#composeModal">New Mail</button>

<div id="mailList" class="flex-grow-1 overflow-auto">
    Inbox mails will be loaded here by app.js 
</div> -->

<div class="d-flex flex-column h-100">

    <!-- New Mail Button -->
    <button
        class="btn btn-primary w-100 mb-3"
        data-bs-toggle="modal"
        data-bs-target="#composeModal">
        + New Mail
    </button>

    <!-- Search -->
    <input
        type="text"
        id="mailSearch"
        class="form-control mb-3"
        placeholder="Search mail...">

    <!-- Mail List -->
    <div
        id="mailList"
        class="flex-grow-1 overflow-auto">
    </div>

</div>