@extends('front.layouts.master')

@section('title', '123 Consulting Solutions - HHSC Approved Home Health, Hospice, PAS Administrator Training')


@section('css')
	<link rel="stylesheet" href="{{ asset('front/css/style1.css') }}" />
	<link rel="stylesheet" href="{{ asset('plugins/jquery/jquery-ui.css') }}" />
@endsection

@section('content')
	<!-- banner section Start -->
	<section class="banner-section section-space-t">
		<div class="container">
			<div class="row">
				<div class="banner-heading-content text-center">
					<h1 class="banner_title section_heading">Start and scale your agency</h1>
					<h3 class="banner_sub_title">Why Texas admin choose Us?</h3>
				</div>
				<div class="banner-card-section d-grid">
					<div class="banner-card-items">
						<div class="banner-card-items-inner">
							<div class="banner-card-items-icon">
								<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
									<path
										d="M11.1825 28.1383C11.0674 27.9938 11.0926 27.7845 11.2389 27.6708C11.3852 27.5572 11.5971 27.5821 11.7123 27.7265C11.8274 27.871 11.8021 28.0804 11.6558 28.1941C11.5095 28.3078 11.2976 28.2828 11.1825 28.1383ZM15.4833 25.8525L10.2769 27.267L10.7657 29.0221L15.9722 27.6077L15.4833 25.8525Z"
										fill="#F36522" />
									<path
										d="M15.0783 24.4616C15.2828 23.0134 14.6837 20.6903 12.2724 19.3022C9.86105 17.9141 8.71296 17.1754 7.74341 16.1925C6.77386 15.2098 6.26114 15.1347 5.91568 15.4032C5.57025 15.6717 5.34868 16.5139 6.38995 17.4024C7.97114 18.7517 9.26658 19.8759 9.54462 20.6594C9.82269 21.4431 9.39961 21.6141 9.24641 21.1544C9.09319 20.6946 8.60935 19.8868 7.17402 18.6873C5.73866 17.4877 5.0197 17.0058 5.18224 15.906C5.3448 14.8062 6.43436 14.8398 6.43436 14.8398C6.43436 14.8398 6.24078 13.2036 6.47857 12.0979C6.7164 10.9923 6.38621 9.77567 5.7314 9.88994C5.7314 9.88994 5.60304 9.46533 5.1999 9.40803C4.79675 9.35069 4.50954 9.62861 4.37707 9.99547C4.10851 10.862 3.66785 12.5289 3.47302 13.0398C3.19265 13.7748 3.40353 14.3566 3.51226 15.0614C3.62099 15.7661 4.12839 18.1079 4.23012 18.8707C4.33185 19.6335 4.33244 20.3697 6.17825 21.7501C8.02407 23.1306 9.88952 24.101 10.2386 25.4083C10.3497 25.8245 10.4921 26.358 10.6345 26.8918L15.101 25.6784C15.044 25.2622 15.0247 24.8405 15.0783 24.4616Z"
										fill="#F36522" />
									<path
										d="M22.2576 28.1941C22.1113 28.0804 22.086 27.871 22.2011 27.7265C22.3163 27.5821 22.5282 27.5572 22.6745 27.6708C22.8208 27.7845 22.846 27.9938 22.7309 28.1383C22.6158 28.2828 22.4039 28.3078 22.2576 28.1941ZM17.9412 27.6077L23.1477 29.0221L23.6365 27.267L18.4301 25.8525L17.9412 27.6077Z"
										fill="#F36522" />
									<path
										d="M18.8353 24.4616C18.6307 23.0134 19.2298 20.6903 21.6411 19.3022C24.0525 17.9141 25.2006 17.1754 26.1701 16.1925C27.1397 15.2098 27.6524 15.1347 27.9979 15.4032C28.3433 15.6717 28.5649 16.5139 27.5236 17.4024C25.9424 18.7517 24.647 19.8759 24.3689 20.6594C24.0909 21.4431 24.5139 21.6141 24.6671 21.1544C24.8204 20.6946 25.3042 19.8868 26.7395 18.6873C28.1749 17.4877 28.8938 17.0058 28.7313 15.906C28.5688 14.8062 27.4792 14.8398 27.4792 14.8398C27.4792 14.8398 27.6728 13.2036 27.435 12.0979C27.1972 10.9923 27.5273 9.77567 28.1821 9.88994C28.1821 9.88994 28.3105 9.46533 28.7136 9.40803C29.1168 9.35069 29.404 9.62861 29.5365 9.99547C29.805 10.862 30.2457 12.5289 30.4405 13.0398C30.7209 13.7748 30.51 14.3566 30.4013 15.0614C30.2926 15.7661 29.7851 18.1079 29.6835 18.8707C29.5817 19.6335 29.5811 20.3697 27.7353 21.7501C25.8895 23.1306 24.024 24.101 23.675 25.4083C23.5638 25.8245 23.4215 26.358 23.2791 26.8918L18.8125 25.6784C18.8696 25.2622 18.8889 24.8405 18.8353 24.4616Z"
										fill="#F36522" />
									<path
										d="M7.69546 12.8869C7.82717 12.8869 7.95955 12.8426 8.06792 12.7519L16.9567 5.31614L25.8454 12.7519C26.0885 12.9553 26.4525 12.9255 26.6583 12.6854C26.8642 12.4453 26.834 12.0859 26.591 11.8826L17.3294 4.135C17.1143 3.955 16.799 3.955 16.5839 4.135L7.32243 11.8826C7.07935 12.0859 7.0492 12.4453 7.25505 12.6854C7.36915 12.8184 7.53174 12.8869 7.69546 12.8869Z"
										fill="#F36522" />
									<path d="M17.3809 13.7492H20.2356V10.9297H17.3809V13.7492Z" fill="#F36522" />
									<path d="M17.3809 17.363H20.2356V14.5435H17.3809V17.363Z" fill="#F36522" />
									<path d="M16.5327 13.7492H13.678V10.9297H16.5327V13.7492Z" fill="#F36522" />
									<path d="M16.5327 17.363H13.678V14.5435H16.5327V17.363Z" fill="#F36522" />
									<path
										d="M23.658 5.27656C23.658 4.85354 23.3108 4.51062 22.8825 4.51062H21.943C21.5147 4.51062 21.1675 4.85354 21.1675 5.27656V6.7229L23.658 8.80623V5.27656Z"
										fill="#F36522" />
								</svg>

							</div>
							<div class="banner-card-items-title"> Home care startup program </div>
						</div>
					</div>
					<div class="banner-card-items">
						<div class="banner-card-items-inner">
							<div class="banner-card-items-icon">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
									<path fill-rule="evenodd" clip-rule="evenodd"
										d="M13.2318 4C16.0691 4 18.3694 6.3209 18.3694 9.18376C18.3694 12.0466 16.0691 14.3675 13.2318 14.3675C10.3944 14.3675 8.09427 12.0466 8.09427 9.18376C8.09427 6.3209 10.3944 4 13.2318 4ZM23.7175 17.6882C24.3751 17.8201 24.9865 18.0812 25.5248 18.444L25.8366 18.2359C26.0772 18.0752 26.3177 17.9142 26.5583 17.7536C26.612 17.7175 26.6853 17.7176 26.7209 17.7536C26.8687 17.9027 27.0162 18.0515 27.1637 18.2003C27.3113 18.3492 27.4588 18.498 27.6063 18.6469C27.6419 18.6828 27.6416 18.7565 27.606 18.8107C27.4467 19.0534 27.2872 19.2963 27.128 19.5389L26.9217 19.8534C27.2815 20.3965 27.5402 21.0135 27.6711 21.6771L28.0366 21.7521C28.3193 21.8102 28.6022 21.8681 28.885 21.926C28.9481 21.939 29 21.9914 29 22.0422C29 22.2529 29 22.4635 29 22.674C29 22.8846 29 23.0949 29 23.3055C29 23.3562 28.9481 23.4082 28.885 23.4212C28.6022 23.4791 28.3193 23.5371 28.0366 23.595L27.6711 23.67C27.5403 24.3336 27.2816 24.9504 26.9218 25.4936L27.1281 25.8081C27.2874 26.0508 27.4468 26.2936 27.6062 26.5363C27.6418 26.5906 27.6418 26.6646 27.6062 26.7005C27.4584 26.8495 27.3109 26.9984 27.1633 27.1473C27.0157 27.2962 26.8683 27.4449 26.7208 27.5938C26.6852 27.6297 26.6121 27.6295 26.5584 27.5935C26.3178 27.4328 26.0772 27.2719 25.8368 27.1112L25.525 26.903C24.9867 27.2659 24.3752 27.527 23.7175 27.6589L23.6432 28.0281C23.5856 28.3132 23.5282 28.5987 23.4709 28.884C23.458 28.9478 23.4061 29 23.3558 29C23.1468 29 22.9382 29 22.7295 29C22.5209 29 22.3124 29 22.1037 29C22.0534 29 22.0019 28.9478 21.989 28.884C21.9316 28.5987 21.8742 28.3132 21.8168 28.0281L21.7424 27.659C21.0847 27.527 20.4732 27.266 19.9349 26.903L19.6232 27.1112C19.3827 27.2719 19.142 27.4328 18.9015 27.5935C18.8476 27.6295 18.7746 27.6297 18.739 27.5938C18.5915 27.4449 18.4441 27.2962 18.2966 27.1473C18.149 26.9984 18.0015 26.8495 17.8538 26.7005C17.8181 26.6646 17.8181 26.5906 17.8537 26.5363C18.013 26.2936 18.1725 26.0508 18.3317 25.8081L18.5381 25.4936C18.1784 24.9504 17.9196 24.3335 17.7889 23.67L17.4232 23.595C17.1406 23.5371 16.8577 23.4791 16.5749 23.4212C16.5117 23.4082 16.4598 23.3562 16.4598 23.3055C16.4598 23.0949 16.4598 22.8846 16.4598 22.674C16.4598 22.4635 16.4598 22.2529 16.4598 22.0422C16.4598 21.9914 16.5117 21.939 16.5749 21.926C16.8577 21.8681 17.1406 21.8102 17.4232 21.7521L17.7889 21.6771C17.9196 21.0135 18.1784 20.3965 18.5382 19.8534L18.3318 19.5389C18.1726 19.2963 18.0132 19.0534 17.8538 18.8107C17.8182 18.7565 17.818 18.6828 17.8535 18.6469C18.0012 18.498 18.1486 18.3492 18.2961 18.2003C18.4436 18.0515 18.5912 17.9027 18.7389 17.7536C18.7745 17.7176 18.848 17.7175 18.9017 17.7536C19.1422 17.9142 19.3828 18.0752 19.6233 18.2359L19.9351 18.444C20.4734 18.0812 21.0849 17.8201 21.7424 17.6882L21.8168 17.3191C21.8742 17.034 21.9316 16.7485 21.989 16.4632C22.0019 16.3994 22.0534 16.3472 22.1037 16.3472C22.3124 16.3472 22.5209 16.3472 22.7295 16.3472C22.9382 16.3472 23.1468 16.3472 23.3558 16.3472C23.4061 16.3472 23.458 16.3994 23.4709 16.4632C23.5282 16.7485 23.5856 17.034 23.6432 17.3191L23.7175 17.6882ZM22.73 19.5448C24.4425 19.5448 25.8309 20.9457 25.8309 22.6736C25.8309 24.4016 24.4425 25.8024 22.73 25.8024C21.0173 25.8024 19.629 24.4016 19.629 22.6736C19.629 20.9457 21.0173 19.5448 22.73 19.5448ZM3.00349 23.6463C3.12202 21.9239 3.29941 20.5168 3.5355 19.425C3.78144 18.2881 4.09603 17.4739 4.47928 16.9825C4.49088 16.9677 4.50319 16.9546 4.51617 16.9432L4.51592 16.9428C5.39402 16.1712 6.35648 15.599 7.34342 15.1827C7.94916 14.9273 8.62463 14.7172 9.3448 14.554C10.4346 15.3586 11.7781 15.8337 13.2318 15.8337C14.687 15.8337 16.0318 15.3575 17.1223 14.5516C17.8319 14.7132 18.5055 14.9232 19.1209 15.1827C19.9125 15.5165 20.6883 15.9508 21.4175 16.5077L21.2728 17.2265C21.0395 17.29 20.8118 17.3685 20.5908 17.4609C20.3692 17.5537 20.1536 17.6611 19.9453 17.7825L19.2065 17.2887C19.0861 17.2083 18.9445 17.168 18.8135 17.168V17.1702C18.6413 17.1702 18.472 17.2331 18.3475 17.3586L17.4622 18.2519C17.3374 18.3778 17.2753 18.5485 17.2755 18.7219C17.2758 18.8563 17.3151 18.9993 17.3933 19.1183L17.8825 19.8636C17.7622 20.0738 17.6556 20.2913 17.5638 20.515C17.4722 20.7378 17.3943 20.9675 17.3314 21.2029L17.3128 21.2068C16.7168 21.3292 16.6704 21.3388 16.7152 21.3296L16.4668 21.3805C16.3231 21.4101 16.1941 21.4823 16.1022 21.575V21.5771C15.9814 21.6993 15.9063 21.8642 15.9063 22.0422V23.3055C15.9063 23.4842 15.9822 23.6495 16.1043 23.7724C16.1971 23.8657 16.3248 23.938 16.4646 23.9666H16.4668L17.3313 24.1438C17.3679 24.2807 17.4096 24.4158 17.4561 24.5486C12.6763 24.8482 8.06266 24.7772 3.23081 24.0375C3.08795 24.0163 2.98543 23.8487 3.0017 23.6631L3.00349 23.6463Z"
										fill="#F36522" />
								</svg>
							</div>
							<div class="banner-card-items-title"> Admin Training </div>
						</div>
					</div>
					<div class="banner-card-items">
						<div class="banner-card-items-inner">
							<div class="banner-card-items-icon">
								<svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
									<path fill-rule="evenodd" clip-rule="evenodd"
										d="M26.9734 18.1927C27.2702 24.0745 25.0685 27.5514 21.1661 29C17.3976 27.641 15.163 24.3186 15.3361 18.1032C17.4271 18.2568 19.5 17.627 21.1413 16.3393C22.8132 17.385 24.9448 18.3738 26.9713 18.1927H26.9734ZM15.9587 6.46583L20.226 10.4107H15.9587V6.46583ZM7.02822 15.5499C7.07301 15.5014 7.1274 15.4625 7.18803 15.4355C7.24866 15.4086 7.31425 15.3942 7.38074 15.3932H16.0082C16.0766 15.3934 16.1442 15.4081 16.2064 15.4361C16.2686 15.4642 16.324 15.5051 16.3689 15.556C16.4609 15.6624 16.5114 15.7976 16.5114 15.9375C16.5114 16.0773 16.4609 16.2125 16.3689 16.3189C16.338 16.3512 16.3034 16.3799 16.2659 16.4044C16.1009 16.4349 15.936 16.4593 15.7711 16.4817H7.38898C7.32049 16.4814 7.25282 16.4669 7.19033 16.4392C7.12784 16.4116 7.07191 16.3713 7.02616 16.321C6.93233 16.2147 6.88065 16.0784 6.88065 15.9375C6.88065 15.7965 6.93233 15.6603 7.02616 15.554L7.02822 15.5499ZM7.02822 18.9536C7.07321 18.9026 7.1286 18.8616 7.19077 18.8332C7.25294 18.8048 7.32048 18.7897 7.38898 18.7888H13.3942C13.4127 19.1611 13.4375 19.5253 13.4705 19.8813H7.38898C7.32045 19.8813 7.25269 19.8669 7.19017 19.8392C7.12764 19.8115 7.07175 19.7711 7.02616 19.7206C6.93233 19.6143 6.88065 19.4781 6.88065 19.3371C6.88065 19.1961 6.93233 19.0599 7.02616 18.9536H7.02822ZM7.02822 22.3553C7.07356 22.3049 7.12907 22.2644 7.19119 22.2363C7.25331 22.2083 7.32068 22.1934 7.38898 22.1925H13.8106C13.8889 22.5683 13.9776 22.9324 14.0765 23.2851H7.38898C7.32022 23.2852 7.25225 23.2707 7.18966 23.2426C7.12706 23.2145 7.07131 23.1735 7.02616 23.1223C6.93187 23.016 6.88051 22.8791 6.88185 22.7378C6.88234 22.5971 6.93431 22.4612 7.02822 22.3553ZM7.02822 12.1462C7.07321 12.0952 7.1286 12.0541 7.19077 12.0257C7.25294 11.9973 7.32048 11.9822 7.38898 11.9814H12.3366C12.4045 11.9815 12.4717 11.9959 12.5335 12.0236C12.5954 12.0513 12.6505 12.0917 12.6953 12.1421C12.7901 12.249 12.8415 12.3866 12.8396 12.5286C12.8397 12.6691 12.7885 12.8049 12.6953 12.9111C12.6502 12.9613 12.595 13.0017 12.5333 13.0297C12.4715 13.0577 12.4046 13.0728 12.3366 13.0739H7.38898C7.32049 13.0736 7.25282 13.0591 7.19033 13.0314C7.12784 13.0038 7.07191 12.9635 7.02616 12.9132C6.9319 12.806 6.88058 12.6685 6.88185 12.5266C6.88005 12.3836 6.93223 12.2451 7.02822 12.138V12.1462ZM7.02822 8.98047C7.07321 8.92949 7.1286 8.88845 7.19077 8.86005C7.25294 8.83165 7.32048 8.81653 7.38898 8.81568H10.1102C10.1776 8.81608 10.2441 8.83041 10.3055 8.85774C10.367 8.88508 10.4219 8.92481 10.4668 8.97437C10.5606 9.08068 10.6123 9.2169 10.6123 9.35787C10.6123 9.49885 10.5606 9.63507 10.4668 9.74138C10.4219 9.79174 10.3667 9.83225 10.305 9.86028C10.2432 9.88832 10.1761 9.90326 10.1081 9.90414H7.38898C7.32045 9.90408 7.25269 9.88973 7.19017 9.86204C7.12764 9.83434 7.07175 9.79391 7.02616 9.74341C6.93233 9.63711 6.88065 9.50089 6.88065 9.35991C6.88065 9.21893 6.93233 9.08271 7.02616 8.97641L7.02822 8.98047ZM22.6009 10.9763C22.5999 10.8245 22.5489 10.677 22.4556 10.5563C22.3622 10.4355 22.2316 10.348 22.0835 10.307L15.7958 4.25839C15.73 4.17736 15.6466 4.11204 15.5516 4.0673C15.4567 4.02256 15.3527 3.99956 15.2475 4.00001H4.27816C3.93917 4.00001 3.61407 4.1329 3.37437 4.36946C3.13468 4.60602 3.00002 4.92686 3.00002 5.2614V26.8394C2.99917 27.0054 3.03192 27.1699 3.09634 27.3233C3.16077 27.4766 3.25558 27.6158 3.37521 27.7325C3.61516 27.968 3.93973 28.1004 4.27816 28.1007H16.5895C16.2016 27.6608 15.8513 27.1899 15.5423 26.6929H4.42658V5.40178H14.528V11.1208C14.5286 11.3082 14.6044 11.4878 14.7389 11.6201C14.8733 11.7524 15.0555 11.8267 15.2454 11.8267H21.1743V14.2315C21.6567 14.5326 22.1323 14.8073 22.6009 15.0555V10.9763ZM17.9955 22.0908L19.1108 22.0766C19.4076 22.1254 20.0178 22.6625 20.2322 22.8904C20.4157 22.6015 20.6054 22.3248 20.8012 22.0562C21.0183 21.7578 21.241 21.473 21.4691 21.2017C21.7165 20.9047 21.9742 20.6219 22.2381 20.3513C22.4669 20.1153 22.8792 19.6392 23.1781 19.5253C23.1869 19.5232 23.1961 19.5232 23.2049 19.5253H24.4253C24.4445 19.5253 24.4628 19.5328 24.4764 19.5462C24.4899 19.5595 24.4975 19.5776 24.4975 19.5965C24.4976 19.6061 24.4957 19.6156 24.4917 19.6244C24.4878 19.6331 24.4821 19.641 24.4748 19.6474L24.2336 19.9058C23.8571 20.3127 23.4984 20.7311 23.1575 21.1611C22.8132 21.5903 22.4855 22.0278 22.1762 22.4692C21.867 22.9107 21.5763 23.3542 21.3001 23.8079C21.0238 24.2616 20.76 24.7296 20.5147 25.1995L20.36 25.4925C20.3509 25.5088 20.3357 25.5211 20.3177 25.5267C20.2997 25.5324 20.2802 25.5311 20.2631 25.523C20.2492 25.5146 20.2378 25.5027 20.2302 25.4884L20.09 25.1914C19.9645 24.9214 19.8227 24.6592 19.6653 24.4061C19.5124 24.1586 19.343 23.9214 19.1582 23.696C18.9741 23.4716 18.7743 23.2602 18.5603 23.0633C18.3416 22.8632 18.108 22.6796 17.8615 22.514C17.8487 22.5051 17.8391 22.4924 17.8343 22.4777C17.8295 22.463 17.8296 22.4472 17.8347 22.4326L17.9233 22.1397C17.9282 22.1246 17.9379 22.1116 17.9509 22.1024C17.9639 22.0933 17.9795 22.0885 17.9955 22.0888V22.0908Z"
										fill="#F36522" />
								</svg>
							</div>
							<div class="banner-card-items-title"> Policy Manual </div>
						</div>
					</div>
					<div class="banner-card-items banner-card-second-row">
						<div class="banner-card-items-inner">
							<div class="banner-card-items-icon">
								<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
									<path
										d="M9.0285 4.09537C8.08544 4.30729 7.34371 5.02783 7.0894 5.99208C6.99404 6.34175 6.99404 7.54971 7.00464 16.673C7.02583 26.3579 7.02583 26.983 7.14239 27.2479C7.43908 27.9791 8.01127 28.5619 8.73181 28.8268L9.11327 28.9751L16.7001 28.9963C22.0194 29.0069 24.4141 28.9963 24.7108 28.9433C25.7704 28.7632 26.5757 28.0321 26.83 27.0148C26.9148 26.6758 26.9254 25.6903 26.9148 18.9406L26.8936 11.2584L24.679 11.2266C22.7505 11.1948 22.422 11.1736 22.1359 11.0676C21.0975 10.6862 20.2816 9.91265 19.9001 8.88482C19.7412 8.45038 19.7306 8.43979 19.7094 6.22519L19.6882 4L14.5597 4.0106C10.4802 4.0106 9.35698 4.02119 9.0285 4.09537ZM15.0789 8.36561V9.40403H16.1173H17.1557V10.4742V11.5445H16.1173H15.0789V12.5829V13.6213H13.9981H12.9279V12.5829V11.5445H11.8895H10.851V10.4848V9.40403H11.8895H12.9279V8.36561V7.32719H13.9981H15.0683V8.36561H15.0789ZM11.6881 16.2809C11.7941 16.3445 11.9212 16.4717 11.9848 16.5776C12.3345 17.2452 11.6352 17.9339 10.9782 17.5843C10.7027 17.4465 10.5861 17.2346 10.5861 16.9167C10.5861 16.673 10.6285 16.5882 10.8087 16.4081C11.0524 16.1538 11.3597 16.1114 11.6881 16.2809ZM23.0896 16.9273V17.4147H18.5015H13.9027V16.9273V16.4399H18.4909H23.079V16.9273H23.0896ZM11.8259 20.2121C11.9848 20.3499 12.0378 20.4664 12.059 20.6889C12.0908 20.9538 12.0696 21.0174 11.8789 21.2187C11.3914 21.7803 10.5755 21.4624 10.5755 20.6995C10.5755 20.5194 10.6285 20.4134 10.7981 20.2439C10.9888 20.0532 11.063 20.0214 11.3173 20.0214C11.561 20.0214 11.6669 20.0638 11.8259 20.2121ZM23.0896 20.7737V21.2611H18.5015H13.9027V20.7737V20.2863H18.4909H23.079V20.7737H23.0896ZM11.8789 24.1009C12.0696 24.3128 12.0908 24.3658 12.059 24.6307C12.0166 25.0439 11.7411 25.2983 11.3279 25.2983C11.0736 25.2983 10.9994 25.2665 10.8087 25.0757C10.6391 24.9062 10.5861 24.8002 10.5861 24.6201C10.5861 23.8678 11.3702 23.5499 11.8789 24.1009ZM23.0896 24.6201V25.1075H18.5015H13.9027V24.6201V24.1327H18.4909H23.079V24.6201H23.0896Z"
										fill="#F36522" />
									<path
										d="M20.6948 6.51128L20.716 8.27024L20.9597 8.76826C21.2564 9.36164 21.6272 9.72191 22.2312 10.008L22.6657 10.2199L24.0961 10.2411C24.8803 10.2517 25.6644 10.2517 25.8445 10.2411L26.1518 10.2199L23.418 7.48613L20.6736 4.75232L20.6948 6.51128Z"
										fill="#F36522" />
								</svg>
							</div>
							<div class="banner-card-items-title"> Medical Contracting </div>
						</div>
					</div>
					<div class="banner-card-items banner-card-second-row">
						<div class="banner-card-items-inner">
							<div class="banner-card-items-icon">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
									<path
										d="M25 8.99994H20.025C19.6612 8.97869 13.3225 8.53244 7.28625 3.46994C6.99476 3.22513 6.63946 3.06859 6.26208 3.01871C5.88471 2.96883 5.50094 3.02768 5.15585 3.18834C4.81076 3.34901 4.51869 3.60482 4.31395 3.92572C4.1092 4.24662 4.00029 4.61929 4 4.99994V24.9999C4.00005 25.3807 4.10879 25.7535 4.31345 26.0746C4.5181 26.3957 4.81015 26.6517 5.15529 26.8125C5.50042 26.9734 5.88429 27.0323 6.26178 26.9825C6.63926 26.9326 6.99468 26.7761 7.28625 26.5312C12.0075 22.5712 16.9113 21.4362 19 21.1187V25.0837C18.9996 25.4133 19.0806 25.7378 19.2359 26.0285C19.3912 26.3192 19.6159 26.567 19.89 26.7499L21.265 27.6662C21.5308 27.8436 21.8352 27.9547 22.1527 27.9903C22.4703 28.0258 22.7917 27.9848 23.0901 27.8706C23.3885 27.7564 23.6553 27.5723 23.8679 27.3339C24.0806 27.0954 24.2331 26.8094 24.3125 26.4999L25.7838 20.9549C27.3047 20.7681 28.6965 20.0064 29.6737 18.8261C30.6509 17.6458 31.1395 16.1363 31.0393 14.6072C30.939 13.0781 30.2575 11.6454 29.1346 10.6027C28.0116 9.5601 26.5323 8.98663 25 8.99994ZM22.375 25.9862V25.9999L21 25.0837V20.9999H23.7L22.375 25.9862ZM25 18.9999H21V10.9999H25C26.0609 10.9999 27.0783 11.4214 27.8284 12.1715C28.5786 12.9217 29 13.9391 29 14.9999C29 16.0608 28.5786 17.0782 27.8284 17.8284C27.0783 18.5785 26.0609 18.9999 25 18.9999Z"
										fill="#F36522" />
								</svg>
							</div>
							<div class="banner-card-items-title"> 1 and 1 Marketing Training </div>
						</div>
					</div>
					<div class="banner-card-items banner-card-second-row">
						<div class="banner-card-items-inner">
							<div class="banner-card-items-icon">
								<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg')}}">
									<path
										d="M14.0442 11.123C14.0465 11.0404 14.0465 10.9579 14.0442 10.8753L14.8996 9.80666C14.9445 9.75055 14.9755 9.6847 14.9902 9.61439C15.005 9.54409 15.003 9.47131 14.9845 9.40191C14.844 8.8749 14.6342 8.36884 14.3607 7.89698C14.3249 7.83524 14.2751 7.78273 14.2154 7.74361C14.1557 7.7045 14.0876 7.67986 14.0167 7.67167L12.6568 7.52032C12.6003 7.46069 12.5429 7.40336 12.4848 7.34833L12.3243 5.985C12.3161 5.91403 12.2913 5.84598 12.2521 5.78625C12.2129 5.72653 12.1603 5.6768 12.0984 5.64102C11.6266 5.36769 11.1205 5.15832 10.5935 5.01841C10.5241 4.99987 10.4513 4.99789 10.381 5.01262C10.3107 5.02736 10.2449 5.05841 10.1888 5.10326L9.12297 5.95404C9.04042 5.95404 8.95786 5.95404 8.87531 5.95404L7.80666 5.10039C7.75055 5.05554 7.6847 5.0245 7.61439 5.00976C7.54409 4.99502 7.47131 4.997 7.40191 5.01554C6.8749 5.15602 6.36884 5.36576 5.89698 5.6393C5.83524 5.67515 5.78273 5.72491 5.74361 5.78463C5.7045 5.84434 5.67986 5.91237 5.67167 5.98328L5.52032 7.34546C5.46069 7.40241 5.40336 7.45974 5.34833 7.51745L3.985 7.67396C3.91403 7.68222 3.84598 7.70694 3.78625 7.74616C3.72653 7.78538 3.6768 7.838 3.64102 7.89985C3.36775 8.37177 3.1582 8.87782 3.01783 9.40478C2.99937 9.47422 2.99748 9.54702 3.01232 9.61733C3.02716 9.68763 3.05831 9.75347 3.10326 9.80953L3.95404 10.8753C3.95404 10.9579 3.95404 11.0404 3.95404 11.123L3.10039 12.1916C3.05554 12.2477 3.0245 12.3136 3.00976 12.3839C2.99502 12.4542 2.997 12.527 3.01554 12.5964C3.15602 13.1234 3.36576 13.6294 3.6393 14.1013C3.67515 14.163 3.72491 14.2156 3.78463 14.2547C3.84434 14.2938 3.91237 14.3184 3.98328 14.3266L5.34317 14.478C5.40011 14.5376 5.45744 14.5949 5.51516 14.65L5.67396 16.0133C5.68222 16.0842 5.70694 16.1523 5.74616 16.212C5.78538 16.2717 5.838 16.3215 5.89985 16.3573C6.37177 16.6305 6.87782 16.8401 7.40478 16.9804C7.47422 16.9989 7.54702 17.0008 7.61733 16.986C7.68763 16.9711 7.75347 16.94 7.80953 16.895L8.87531 16.0442C8.95786 16.0465 9.04042 16.0465 9.12297 16.0442L10.1916 16.8996C10.2477 16.9445 10.3136 16.9755 10.3839 16.9902C10.4542 17.005 10.527 17.003 10.5964 16.9845C11.1235 16.8442 11.6296 16.6345 12.1013 16.3607C12.163 16.3249 12.2156 16.2751 12.2547 16.2154C12.2938 16.1557 12.3184 16.0876 12.3266 16.0167L12.478 14.6568C12.5376 14.6003 12.5949 14.5429 12.65 14.4848L14.0133 14.3243C14.0842 14.3161 14.1523 14.2913 14.212 14.2521C14.2717 14.2129 14.3215 14.1603 14.3573 14.0984C14.6305 13.6265 14.8401 13.1205 14.9804 12.5935C14.9989 12.5241 15.0008 12.4513 14.986 12.381C14.9711 12.3106 14.94 12.2448 14.895 12.1888L14.0442 11.123ZM8.99914 13.2924C8.54558 13.2924 8.10221 13.1579 7.72509 12.9059C7.34797 12.6539 7.05404 12.2958 6.88048 11.8767C6.70691 11.4577 6.66149 10.9966 6.74998 10.5518C6.83846 10.1069 7.05687 9.6983 7.37758 9.37758C7.6983 9.05687 8.10691 8.83846 8.55175 8.74998C8.9966 8.66149 9.45769 8.70691 9.87672 8.88048C10.2958 9.05404 10.6539 9.34797 10.9059 9.72509C11.1579 10.1022 11.2924 10.5456 11.2924 10.9991C11.2924 11.6073 11.0508 12.1906 10.6207 12.6207C10.1906 13.0508 9.60734 13.2924 8.99914 13.2924Z"
										fill="#F36522" />
									<path
										d="M27.7256 20.164C27.7287 20.0539 27.7287 19.9438 27.7256 19.8337L28.8661 18.4089C28.9259 18.3341 28.9673 18.2463 28.987 18.1525C29.0066 18.0588 29.004 17.9617 28.9793 17.8692C28.792 17.1665 28.5123 16.4918 28.1476 15.8626C28.0998 15.7803 28.0335 15.7103 27.9538 15.6582C27.8742 15.606 27.7835 15.5732 27.689 15.5622L25.8758 15.3604C25.8004 15.2809 25.7239 15.2045 25.6465 15.1311L25.4324 13.3133C25.4214 13.2187 25.3885 13.128 25.3362 13.0483C25.2839 12.9687 25.2137 12.9024 25.1312 12.8547C24.5021 12.4903 23.8274 12.2111 23.1247 12.0245C23.0321 11.9998 22.9351 11.9972 22.8414 12.0168C22.7476 12.0365 22.6598 12.0779 22.585 12.1377L21.164 13.2721C21.0539 13.2721 20.9438 13.2721 20.8337 13.2721L19.4089 12.1339C19.3341 12.0741 19.2463 12.0327 19.1525 12.013C19.0588 11.9934 18.9617 11.996 18.8692 12.0207C18.1665 12.208 17.4918 12.4877 16.8626 12.8524C16.7803 12.9002 16.7103 12.9665 16.6582 13.0462C16.606 13.1258 16.5732 13.2165 16.5622 13.311L16.3604 15.1273C16.2809 15.2032 16.2045 15.2796 16.1311 15.3566L14.3133 15.5653C14.2187 15.5763 14.128 15.6093 14.0483 15.6615C13.9687 15.7138 13.9024 15.784 13.8547 15.8665C13.4903 16.4957 13.2109 17.1704 13.0238 17.873C12.9992 17.9656 12.9966 18.0627 13.0164 18.1564C13.0362 18.2502 13.0777 18.338 13.1377 18.4127L14.2721 19.8337C14.2721 19.9438 14.2721 20.0539 14.2721 20.164L13.1339 21.5888C13.0741 21.6636 13.0327 21.7514 13.013 21.8452C12.9934 21.9389 12.996 22.036 13.0207 22.1285C13.208 22.8312 13.4877 23.5059 13.8524 24.1351C13.9002 24.2174 13.9665 24.2874 14.0462 24.3396C14.1258 24.3917 14.2165 24.4246 14.311 24.4355L16.1242 24.6373C16.2002 24.7168 16.2766 24.7932 16.3535 24.8666L16.5653 26.6844C16.5763 26.779 16.6093 26.8697 16.6615 26.9494C16.7138 27.029 16.784 27.0953 16.8665 27.143C17.4957 27.5074 18.1704 27.7868 18.873 27.9739C18.9656 27.9985 19.0627 28.0011 19.1564 27.9813C19.2502 27.9615 19.338 27.92 19.4127 27.86L20.8337 26.7256C20.9438 26.7287 21.0539 26.7287 21.164 26.7256L22.5888 27.8661C22.6636 27.9259 22.7514 27.9673 22.8452 27.987C22.9389 28.0066 23.036 28.004 23.1285 27.9793C23.8313 27.7923 24.5061 27.5126 25.1351 27.1476C25.2174 27.0998 25.2874 27.0335 25.3396 26.9538C25.3917 26.8742 25.4246 26.7835 25.4355 26.689L25.6373 24.8758C25.7168 24.8004 25.7932 24.7239 25.8666 24.6465L27.6844 24.4324C27.779 24.4214 27.8697 24.3885 27.9494 24.3362C28.029 24.2839 28.0953 24.2137 28.143 24.1312C28.5074 23.502 28.7868 22.8273 28.9739 22.1247C28.9985 22.0321 29.0011 21.935 28.9813 21.8413C28.9615 21.7475 28.92 21.6597 28.86 21.585L27.7256 20.164ZM20.9989 23.0565C20.3941 23.0565 19.8029 22.8772 19.3001 22.5412C18.7973 22.2052 18.4054 21.7277 18.174 21.169C17.9425 20.6102 17.882 19.9955 18 19.4023C18.1179 18.8092 18.4092 18.2644 18.8368 17.8368C19.2644 17.4092 19.8092 17.1179 20.4023 17C20.9955 16.882 21.6102 16.9425 22.169 17.174C22.7277 17.4054 23.2052 17.7973 23.5412 18.3001C23.8772 18.8029 24.0565 19.3941 24.0565 19.9989C24.0565 20.8098 23.7343 21.5875 23.1609 22.1609C22.5875 22.7343 21.8098 23.0565 20.9989 23.0565Z"
										fill="#F36522" />
								</svg>
							</div>
							<div class="banner-card-items-title"> Operation Training </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- banner section End -->

	<!-- Trusted Customers Section Start -->
	<section class="trusted-customers-section section-space-tb">
		<div class="container">
			<div class="trusted-customers-slider">
				<a class="trusted-customers-slider-items" href="/">
					<img src="{{ asset('assets/images/senior-helpers.svg') }}" width="140px" height="70px"
						alt="trusted customers image">
				</a>
				<a class="trusted-customers-slider-items" href="/">
					<img src="{{ asset('assets/images/nurse-next-door.svg') }}" width="140px" height="70px"
						alt="trusted customers image">
				</a>
				<a class="trusted-customers-slider-items" href="/">
					<img src="{{ asset('assets/images/first-light.svg') }}" width="140px" height="70px"
						alt="trusted customers image">
				</a>
				<a class="trusted-customers-slider-items" href="/">
					<img src="{{ asset('assets/images/right-at-home.svg') }}" width="140px" height="70px"
						alt="trusted customers image">
				</a>
				<a class="trusted-customers-slider-items" href="/">
					<img src="{{ asset('assets/images/home-instead.svg') }}" width="140px" height="70px"
						alt="trusted customers image">
				</a>
				<a class="trusted-customers-slider-items" href="/">
					<img src="{{ asset('assets/images/visiting-angels.svg') }}" width="140px" height="70px"
						alt="trusted customers image">
				</a>
			</div>
		</div>
	</section>
	<!-- Trusted Customers Section End -->

	<!-- Our Courses Section Start -->
	<section class="our-courses-section section-space-b">
		<div class="container">
			{{-- <div class="row">
				<divc class="our-courses-section-title section_heading text-center"> Our Courses
			</div> --}}
			@php
				$route = Route::currentRouteName();
			@endphp
			<div class="our-courses-tabing">
				<ul class="nav nav-tabs" id="courseTabs" role="tablist">
					@foreach ($categories as $key => $category)
						@if ($key == 0)
							<li class="nav-item" role="presentation">
								<a href="{{ route('home.category', $category->slug_relation->slug) }}" data-id="{{ $category->id }}"
									class="nav-link text-center courses-tab--item category @if (isset($selectedCategory)) @if ($selectedCategory->id == $category->id) active @endif
@else
@if ($loop->first && !$policy_manuals) active @endif 
							@endif"
									title="{{ $category->name }}">{{ ucwords($category->name) }}</a>
							</li>
						@endif
					@endforeach
					<li class="nav-item" role="presentation">
						<a href="{{ route('home.startup.program') }}"
							class="nav-link text-center courses-tab--item category @if ($route == 'home.startup.program') active @endif"
							title="Policy Manuals">Startup Program</a>
					</li>
					<li class="nav-item" role="presentation">
						<a href="{{ route('home.policies.cards') }}"
							class="nav-link text-center courses-tab--item category @if ($route == 'home.policies.cards') active @endif"
							title="Policy Manuals">Policy Manuals</a>
					</li>
				</ul>

				<!-- Tab Content -->
				<div class="tab-content" id="courseTabsContent">
					<!-- Admin Tab -->

					@if ($route == 'home.startup.program')
						<div class="tab-pane fade show active" id="startup" role="tabpanel">
							<div class="startup-program-content">
								<div class="heading-with-image text-center">
									<h2 class="startup-program-section-title">HOME CARE STARTUP PROGRAM</h2>
									<img src="{{ asset('front/images/startup-program/home-care-startup-program-img.png') }}" width="1170"
										height="400" alt="HOME CARE" class="heading-with-image-img">
									<p class="heading-with-image-desc">Your Path to Building a Thriving Home Care Business. <br> Start Your
										Home
										Care Agency with Confidence—Get Your First Client in Record Time! <br> Are you ready to launch your
										own
										home care agency but overwhelmed by the complexities of <br> compliance, the time-consuming processes,
										and
										not knowing where to start?</p>
									<p class="heading-with-image-desc covered-content">We’ve got you covered.</p>
									<p class="heading-with-image-desc">With 123 Consulting Solutions, you’ll have everything you need to
										start and grow your <br> home care agency—without the stress or guesswork. Our Done-for-You Package
										will
										take you <br> from idea to first client, handling the heavy lifting so you can focus on what matters
										most: <br>
										building your dream business.</p>
								</div>
								<div class="whats-included-section">
									<h2 class="whats-included-section-title startup-program-section-title text-center">What’s Included?</h2>
									<div class="included-box-listing">
										<div class="included-box-items">
											<div class="included-box-item d-flex align-items-center">
												<div class="included-box-image">
													<img src="{{ asset('front/images/startup-program/startup-program-img1.png') }}" width="470"
														height="300" alt="TULIP Application Completion" class="included-box-img">
												</div>
												<div class="included-box-content">
													<h3 class="included-box-title">TULIP Application Completion</h3>
													<ul class="included-box-description">
														<li>End-to-end TULIP application preparation and subm</li>
														<li>PAS administrator training</li>
														<li>Registration of your NPI number</li>
														<li>State-ready policies for compliance</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="included-box-items">
											<div class="included-box-item d-flex align-items-center">
												<div class="included-box-image">
													<img src="{{ asset('front/images/startup-program/startup-program-img2.png') }}" width="470"
														height="300" alt="Comprehensive Policy & Procedure Manuals" class="included-box-img">
												</div>
												<div class="included-box-content">
													<h3 class="included-box-title">Comprehensive Policy & Procedure Manuals</h3>
													<ul class="included-box-description">
														<li>PAS Policy Manual, QAPI Binder, Emergency</li>
														<li>Employee Handbook and Binder</li>
														<li>MCO contracting</li>
														<li>Client Admission Packet to make onboarding seamless</li>
														<li>Complaint and Satisfaction Survey Binders</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="included-box-items">
											<div class="included-box-item d-flex align-items-center">
												<div class="included-box-image">
													<img src="{{ asset('front/images/startup-program/startup-program-img3.png') }}" width="470"
														height="300" alt="Professional Website Creation" class="included-box-img">
												</div>
												<div class="included-box-content">
													<h3 class="included-box-title">Professional Website Creation</h3>
													<ul class="included-box-description">
														<li>SEO keyword research to rank high on Google</li>
														<li>Compelling content that converts leads</li>
														<li>Lead magnets and a sales funnel for continuous growth</li>
														<li>Medicare Advantage plan resources</li>
														<li>Google Business Page setup</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="included-box-items">
											<div class="included-box-item d-flex align-items-center">
												<div class="included-box-image">
													<img src="{{ asset('front/images/startup-program/startup-program-img4.png') }}" width="470"
														height="300" alt="Contracts & Medicaid Applications" class="included-box-img">
												</div>
												<div class="included-box-content">
													<h3 class="included-box-title">Contracts & Medicaid Applications</h3>
													<ul class="included-box-description">
														<li>Medicaid application completion</li>
														<li>PHC contract</li>
														<li>MCO contracting</li>
														<li>Medicare Advantage plan resources</li>
														<li>MCO application list (a $500 value)</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="included-box-items">
											<div class="included-box-item d-flex align-items-center">
												<div class="included-box-image">
													<img src="{{ asset('front/images/startup-program/startup-program-img5.png') }}" width="470"
														height="300" alt="Marketing Mastery" class="included-box-img">
												</div>
												<div class="included-box-content">
													<h3 class="included-box-title">Marketing Mastery</h3>
													<ul class="included-box-description">
														<li>Learn how to secure private pay referral sources</li>
														<li>Proven scripts for marketing calls and emails</li>
														<li>Competitive analysis, objection handling, and follow-up strategies</li>
														<li>Prequalified referral lists (a $1000 value)</li>
														<li>Actionable steps to reach decision-makers</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="included-box-items">
											<div class="included-box-item d-flex align-items-center">
												<div class="included-box-image">
													<img src="{{ asset('front/images/startup-program/startup-program-img6.png') }}" width="470"
														height="300" alt="Operations Support" class="included-box-img">
												</div>
												<div class="included-box-content">
													<h3 class="included-box-title">Operations Support</h3>
													<ul class="included-box-description">
														<li>Care management software recommendations</li>
														<li>Hiring, onboarding, and training software guidance</li>
														<li>3 months of sales and operations training classes (a $997 value!)</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>





								<div class="why-choose-section">
									<h2 class="why-choose-section-title startup-program-section-title text-center">Why Choose us?</h2>
									<div class="row">
										<div class="col-lg-4">
											<div class="why-choose-left-image">
												<img src="{{ asset('front/images/startup-program/why-choose-us-image.png') }}" width="370"
													height="589" alt="Why Choose us" class="why-choose-image">
											</div>
										</div>
										<div class="col-lg-8">
											<div class="why-choose-right-content">
												<div class="why-choose-card">
													<div class="why-choose-card-inner">
														<h4 class="why-choose-card-title">Launch Your Agency in Just Weeks or Your Money Back.</h4>
														<p class="why-choose-card-description">If we don’t help you get your home care agency
															operational in record time, you get every penny back. No risk, just results.</p>
													</div>
												</div>
												<div class="why-choose-card">
													<div class="why-choose-card-inner">
														<h4 class="why-choose-card-title">Proven Track Record of Success.</h4>
														<p class="why-choose-card-description">123 Consulting Solutions helped me launch my agency in
															under 60 days. I signed my first client within weeks of starting!” – Satisfied Client</p>
													</div>
												</div>
												<div class="why-choose-card">
													<div class="why-choose-card-inner">
														<h4 class="why-choose-card-title">Limited Availability—Only 5 Spots per Month.</h4>
														<p class="why-choose-card-description">We work closely with our clients to ensure every detail
															is perfect, so we only accept 5 clients per month.</p>
													</div>
												</div>
												<div class="why-choose-card">
													<div class="why-choose-card-inner">
														<h4 class="why-choose-card-title">Exclusive Bonus: Free Training on Signing Your First Client.
														</h4>
														<p class="why-choose-card-description">We’ll guide you step-by-step to ensure you land your
															first client faster than you thought possible.</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="dont-miss-out-section">
									<div class="dont-miss-out-content text-center">
										<h2 class="startup-program-section-title dont-miss-out-title">Don’t Miss Out!</h2>
										<p class="dont-miss-out-description">Be one of the few to start your home care agency the right way.
											With our proven system, expert guidance, and <br> tools tailored to your success, you’ll be ready to
											hit the ground running and <br> secure your first client in no time.</p>
										<div class="dont-miss-out-saperation"></div>
										<h2 class="startup-program-section-title dont-miss-out-title">Act Now Before Spots Fill Up</h2>
										<p class="dont-miss-out-description">We only take 5 new clients each month to give you the
											personalized attention you deserve. Don’t wait until next <br> month to make your dream a reality.
										</p>
									</div>
								</div>
								<div class="schedule-consultation-section">
									<p class="schedule-consultation-text text-center">Click the link below to schedule your consultation and
										take the first step toward building your own home care agency.</p>

									<a href="{{ route('front.consultation-booking') }}"
										class="btn button-primary schedule-consultation-button d-flex align-items-center mx-auto">
										<svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M26.5 4H23.5V3C23.5 2.73478 23.3946 2.48043 23.2071 2.29289C23.0196 2.10536 22.7652 2 22.5 2C22.2348 2 21.9804 2.10536 21.7929 2.29289C21.6054 2.48043 21.5 2.73478 21.5 3V4H11.5V3C11.5 2.73478 11.3946 2.48043 11.2071 2.29289C11.0196 2.10536 10.7652 2 10.5 2C10.2348 2 9.98043 2.10536 9.79289 2.29289C9.60536 2.48043 9.5 2.73478 9.5 3V4H6.5C5.96957 4 5.46086 4.21071 5.08579 4.58579C4.71071 4.96086 4.5 5.46957 4.5 6V26C4.5 26.5304 4.71071 27.0391 5.08579 27.4142C5.46086 27.7893 5.96957 28 6.5 28H26.5C27.0304 28 27.5391 27.7893 27.9142 27.4142C28.2893 27.0391 28.5 26.5304 28.5 26V6C28.5 5.46957 28.2893 4.96086 27.9142 4.58579C27.5391 4.21071 27.0304 4 26.5 4ZM9.5 6V7C9.5 7.26522 9.60536 7.51957 9.79289 7.70711C9.98043 7.89464 10.2348 8 10.5 8C10.7652 8 11.0196 7.89464 11.2071 7.70711C11.3946 7.51957 11.5 7.26522 11.5 7V6H21.5V7C21.5 7.26522 21.6054 7.51957 21.7929 7.70711C21.9804 7.89464 22.2348 8 22.5 8C22.7652 8 23.0196 7.89464 23.2071 7.70711C23.3946 7.51957 23.5 7.26522 23.5 7V6H26.5V10H6.5V6H9.5ZM26.5 26H6.5V12H26.5V26ZM18 16.5C18 16.7967 17.912 17.0867 17.7472 17.3334C17.5824 17.58 17.3481 17.7723 17.074 17.8858C16.7999 17.9993 16.4983 18.0291 16.2074 17.9712C15.9164 17.9133 15.6491 17.7704 15.4393 17.5607C15.2296 17.3509 15.0867 17.0836 15.0288 16.7926C14.9709 16.5017 15.0006 16.2001 15.1142 15.926C15.2277 15.6519 15.42 15.4176 15.6666 15.2528C15.9133 15.088 16.2033 15 16.5 15C16.8978 15 17.2794 15.158 17.5607 15.4393C17.842 15.7206 18 16.1022 18 16.5ZM23.5 16.5C23.5 16.7967 23.412 17.0867 23.2472 17.3334C23.0824 17.58 22.8481 17.7723 22.574 17.8858C22.2999 17.9993 21.9983 18.0291 21.7074 17.9712C21.4164 17.9133 21.1491 17.7704 20.9393 17.5607C20.7296 17.3509 20.5867 17.0836 20.5288 16.7926C20.4709 16.5017 20.5007 16.2001 20.6142 15.926C20.7277 15.6519 20.92 15.4176 21.1666 15.2528C21.4133 15.088 21.7033 15 22 15C22.3978 15 22.7794 15.158 23.0607 15.4393C23.342 15.7206 23.5 16.1022 23.5 16.5ZM12.5 21.5C12.5 21.7967 12.412 22.0867 12.2472 22.3334C12.0824 22.58 11.8481 22.7723 11.574 22.8858C11.2999 22.9993 10.9983 23.0291 10.7074 22.9712C10.4164 22.9133 10.1491 22.7704 9.93934 22.5607C9.72956 22.3509 9.5867 22.0836 9.52882 21.7926C9.47094 21.5017 9.50065 21.2001 9.61418 20.926C9.72771 20.6519 9.91997 20.4176 10.1666 20.2528C10.4133 20.088 10.7033 20 11 20C11.3978 20 11.7794 20.158 12.0607 20.4393C12.342 20.7206 12.5 21.1022 12.5 21.5ZM18 21.5C18 21.7967 17.912 22.0867 17.7472 22.3334C17.5824 22.58 17.3481 22.7723 17.074 22.8858C16.7999 22.9993 16.4983 23.0291 16.2074 22.9712C15.9164 22.9133 15.6491 22.7704 15.4393 22.5607C15.2296 22.3509 15.0867 22.0836 15.0288 21.7926C14.9709 21.5017 15.0006 21.2001 15.1142 20.926C15.2277 20.6519 15.42 20.4176 15.6666 20.2528C15.9133 20.088 16.2033 20 16.5 20C16.8978 20 17.2794 20.158 17.5607 20.4393C17.842 20.7206 18 21.1022 18 21.5ZM23.5 21.5C23.5 21.7967 23.412 22.0867 23.2472 22.3334C23.0824 22.58 22.8481 22.7723 22.574 22.8858C22.2999 22.9993 21.9983 23.0291 21.7074 22.9712C21.4164 22.9133 21.1491 22.7704 20.9393 22.5607C20.7296 22.3509 20.5867 22.0836 20.5288 21.7926C20.4709 21.5017 20.5007 21.2001 20.6142 20.926C20.7277 20.6519 20.92 20.4176 21.1666 20.2528C21.4133 20.088 21.7033 20 22 20C22.3978 20 22.7794 20.158 23.0607 20.4393C23.342 20.7206 23.5 21.1022 23.5 21.5Z"
												fill="white" />
										</svg>
										SCHEDULE YOUR FREE CALL NOW
									</a>
									<h2 class="startup-program-section-title text-center get-started-title">Your future is waiting—let’s get
										started!
									</h2>
								</div>
							</div>
						</div>
					@else
						<div class="tab-pane fade show active" id="admin" role="tabpanel">
							<div class="tabing-content-details ">
								<div class="tabing-search-content d-flex align-items-center justify-content-between">
									<div class="available-courses">
										<span class="totalCourse"></span> Courses Available
									</div>
									<div class="available-courses-search">
										<div class="search-courses">
											<input type="text" placeholder="Search" name="search" id="search" />
											<button class="search-courses-btn p-0">
												<img src="{{ asset('assets/images/search-icon.svg') }}" width="24px" height="24px" alt="search icon">
											</button>
										</div>
									</div>
								</div>

								<div class="courselist row">
								</div>
							</div>
						</div>
					@endif
				</div>

			</div>
		</div>
		</div>
		</div>
	</section>
	<!-- Our Courses Section End -->
@endsection
@section('js')
	<script>
		getCourseList();
		set_ratings_star();

		function set_ratings_star() {
			$(".course-ratings-box").starRating({
				initialRating: 0,
				strokeWidth: 0,
				minRating: 0.5,
				starSize: 20,
				ratedColor: 'orange',
				activeColor: 'orange',
				readOnly: true,
				disableAfterRate: true,
			});

			$.each($(".course-ratings-box"), function(indexOfElement, formElement) {
				$(this).starRating('setRating', parseFloat($(this).data('average-ratings')), false);
			});
		}

		function getCourseList(name = null) {
			let searchPlaceHolder = "Search Course";
			let id = $('.category.active').data('id');
			let url = "{{ route('coursebycategory', [':id']) }}";
			url = url.replace(':id', id);

			if (typeof(id) == "undefined") {
				searchPlaceHolder = "Search Policy";
				url = "{{ route('policies.cards.ajax') }}";
			}

			$.ajax({
				url: url,
				method: 'get',
				dataType: 'json',
				data: {
					name: name
				},
				global: false,
				success: function(data) {
					$('.totalCourse').html(data?.total_items)
					$('#search').val("").attr("placeholder", searchPlaceHolder);
					$('.courselist').html(data.data);
					set_ratings_star();
				}
			});
		}

		$('body').on('click', '.category', function() {
			$('.category').removeClass('active');
			$(this).addClass('active');
			getCourseList();
		});

		$('#search').autocomplete({

			source: function(request, response) {
				let searchUrl = "{{ route('course.search') }}";
				if (typeof($('.category.active').data('id')) == "undefined") {
					searchUrl = "{{ route('policy.search') }}";
				}
				$.ajax({
					url: searchUrl,
					dataType: "json",
					global: false,
					data: {
						search: request.term,
						category: $('.category.active').data('id')
					},
					success: function(data) {

						response(data);
					}
				});
			},
			minLength: 1,
			select: function(event, ui) {
				getCourseList(ui.item.label);
			}
		});

		$(document).on("click", "li.page-item a.page-link", function(event) {
			event.preventDefault();
			let url = $(this).attr("href");
			$.ajax({
				url: url,
				method: 'get',
				dataType: 'json',
				success: function(data) {
					$('#search').val("");
					$('.courselist').html(data.data);
					set_ratings_star();
				}
			});

		});
	</script>
@endsection
