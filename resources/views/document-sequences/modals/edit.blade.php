<div class="modal fade"
     id="editSequenceModal"
     tabindex="-1"
     aria-labelledby="editSequenceModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form id="editSequenceForm">

                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    id="sequence_id"
                    name="sequence_id">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="editSequenceModalLabel">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Document Sequence

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>



                <div class="modal-body">

                    <div class="row g-4">

                        {{-- Document Type --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Document Type

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="document_type"
                                readonly>

                        </div>



                        {{-- Prefix --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Prefix

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="prefix"
                                name="prefix">

                            <div
                                class="invalid-feedback">
                            </div>

                        </div>



                        {{-- Suffix --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Suffix

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="suffix"
                                name="suffix">

                            <div
                                class="invalid-feedback">
                            </div>

                        </div>



                        {{-- Separator --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Separator

                            </label>

                            <select
                                class="form-select"
                                id="separator"
                                name="separator">

                                <option value="-">Hyphen (-)</option>

                                <option value="/">Slash (/)</option>

                                <option value="_">Underscore (_)</option>

                                <option value=".">Dot (.)</option>

                                <option value="">None</option>

                            </select>

                            <div
                                class="invalid-feedback">
                            </div>

                        </div>



                        {{-- Current Number --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Current Number

                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="current_number"
                                name="current_number"
                                min="1">

                            <div
                                class="invalid-feedback">
                            </div>

                        </div>



                        {{-- Number Length --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Number Length

                            </label>

                            <select
                                class="form-select"
                                id="number_length"
                                name="number_length">

                                @for($i = 4; $i <= 10; $i++)

                                    <option value="{{ $i }}">

                                        {{ $i }} Digits

                                    </option>

                                @endfor

                            </select>

                            <div
                                class="invalid-feedback">
                            </div>

                        </div>



                        {{-- Reset Frequency --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Reset Frequency

                            </label>

                            <select
                                class="form-select"
                                id="reset_frequency"
                                name="reset_frequency">

                                <option value="Never">

                                    Never

                                </option>

                                <option value="Daily">

                                    Daily

                                </option>

                                <option value="Monthly">

                                    Monthly

                                </option>

                                <option value="Yearly">

                                    Yearly

                                </option>

                            </select>

                            <div
                                class="invalid-feedback">
                            </div>

                        </div>



                        {{-- Live Preview --}}

                        <div class="col-md-6">

                            <label class="form-label">

                                Preview

                            </label>

                            <div
                                id="sequencePreview"
                                class="sequence-preview">

                                INV-000001

                            </div>

                        </div>

                    </div>

                </div>



                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle me-2"></i>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>