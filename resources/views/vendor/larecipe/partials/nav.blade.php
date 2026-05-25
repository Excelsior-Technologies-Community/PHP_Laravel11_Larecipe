<div class="fixed pin-t pin-x z-40">
    <div class="bg-gradient-primary text-white h-1"></div>

    <nav class="flex items-center justify-between text-black bg-navbar shadow-xs h-16">
        <div class="flex items-center flex-no-shrink">
            <a href="{{ url('/') }}" class="flex items-center flex-no-shrink text-black mx-4">
                @include("larecipe::partials.logo")

                <p class="inline-block font-semibold mx-1 text-grey-dark">
                    {{ config('app.name') }}
                </p>
            </a>

            <div class="switch">
                <input type="checkbox" name="1" id="1" v-model="sidebar" class="switch-checkbox" />
                <label class="switch-label" for="1"></label>
            </div>
        </div>

        <div class="block mx-4 flex items-center">
            @if(config('larecipe.search.enabled'))
                <larecipe-button id="search-button"
                    :type="searchBox ? 'primary' : 'link'"
                    @click="searchBox = ! searchBox"
                    class="px-4">
                    <i class="fas fa-search" id="search-button-icon"></i>
                </larecipe-button>
            @endif

            <larecipe-dropdown>
                <larecipe-button type="primary" class="flex">
                    {{ $currentVersion }} <i class="mx-1 fa fa-angle-down"></i>
                </larecipe-button>

                <template slot="list">
                    <ul class="list-reset">
                        @foreach ($versions as $version)
                            <li class="py-2 hover:bg-grey-lightest">
                                <a class="px-6 text-grey-darkest" href="{{ route('larecipe.show', ['version' => $version, 'page' => $currentSection]) }}">{{ $version }}</a>
                            </li>
                        @endforeach
                    </ul>
                </template>
            </larecipe-dropdown>

            @auth
                <larecipe-dropdown>
                    <larecipe-button type="white" class="ml-2">
                        {{ auth()->user()->name ?? 'Account' }} <i class="fa fa-angle-down"></i>
                    </larecipe-button>

                    <template slot="list">
                        <form action="/logout" method="POST">
                            {{ csrf_field() }}

                            <button type="submit" class="py-2 px-4 text-white bg-danger inline-flex"><i class="fa fa-power-off mr-2"></i> Logout</button>
                        </form>
                    </template>
                </larecipe-dropdown>
            @endauth
        </div>
    </nav>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener("keydown", function (e) {
    if (e.key !== "Enter") return;
    let active = document.activeElement;
    if (!active) return;
    let value = active.value;
    if (!value) return;

    fetch('/docs/search-log', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ query: value })
    })
    .then(async res => {
        let data = await res.text();
        console.log("RAW RESPONSE:", data);
        try {
            let json = JSON.parse(data);
            console.log("SUCCESS:", json);
        } catch (err) {
            console.log("NOT JSON RESPONSE:", data);
        }
    })
    .catch(err => console.log("NETWORK ERROR:", err));
});

document.addEventListener("DOMContentLoaded", function() {
    let navbar = document.querySelector('.block.mx-4.flex.items-center');
    if(navbar) {
        let pdfBtn = document.createElement('button');
        pdfBtn.onclick = downloadPDF;
        pdfBtn.className = "bg-red text-white font-bold py-2 px-4 rounded ml-2 shadow";
        pdfBtn.style.fontSize = "12px";
        pdfBtn.innerHTML = "📥 Download PDF";
        navbar.insertBefore(pdfBtn, navbar.firstChild);
    }

    let contentArea = document.querySelector('.documentation');
    if(contentArea) {
        let feedbackHTML = `
            <div id="feedback-box" style="margin-top: 50px; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; text-align: center;">
                <h4 style="margin-bottom: 15px; color: #334155;">Was this page helpful?</h4>
                <button onclick="sendFeedback('like')" style="background: #22c55e; color: white; border: none; padding: 8px 20px; border-radius: 5px; margin-right: 10px; cursor: pointer; font-weight: bold;">👍 Yes</button>
                <button onclick="sendFeedback('dislike')" style="background: #ef4444; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">👎 No</button>
                <p id="feedback-msg" style="display:none; color: #10b981; margin-top: 10px; font-weight: bold;">Thank you for your feedback!</p>
            </div>
        `;
        contentArea.insertAdjacentHTML('beforeend', feedbackHTML);
    }
});

function downloadPDF() {
    let element = document.querySelector('.documentation');
    if(!element) return;
    let opt = {
      margin:       0.5,
      filename:     'documentation.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
}

function sendFeedback(type) {
    let pagePath = window.location.pathname;
    
    fetch('/docs/feedback', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ type: type, page_path: pagePath })
    }).then(response => response.json())
      .then(data => {
          if(data.success) {
              document.getElementById('feedback-msg').style.display = 'block';
          }
      });
}
</script>