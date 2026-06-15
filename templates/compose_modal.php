<div class="modal fade" id="composeModal">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary text-light">
            <div class="modal-header">
                <h5 class="modal-title">New Mail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newMailForm">
                    <input type="email" name="to" class="form-control mb-2" placeholder="To" required>
                    <input type="text" name="subject" class="form-control mb-2" placeholder="Subject" required>
                    <textarea name="body" class="form-control mb-2" placeholder="Message" rows="5" required></textarea>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>