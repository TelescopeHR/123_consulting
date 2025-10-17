@extends('front.layouts.master')

@section('title', 'Blog - 123 Consulting Solutions')
@section('css')
	<style>
		.image-box img {
			object-fit: fill;
		}
	</style>
@endsection

@section('content')
	<section class="section section-blog-listing ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="blog-post-featured">
                            <div class="blog-post-featured-image">
                                <img src="https://blog.hubspot.com/hs-fs/hubfs/hubspot-blog-marketing-industry-trends-report-1.jpg?width=1806&height=900&name=hubspot-blog-marketing-industry-trends-report-1.jpg" 
                                alt=""
                                class="w-100">
                            </div>
                            <div class="blog-post-featured-body">
                                <h3 class="blog-post-featured-title">
                                   <a href=""> The HubSpot Blog's 2023 Marketing Strategy & Trends Report: Data from 1,200+ Global Marketers</a>
                                </h3>
                                <p class="blog-post-featured-desc"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam illum molestiae harum consequatur veritatis consequuntur neque ex quam quas ut, voluptatum eos maiores nam inventore vitae dolorem obcaecati laboriosam quod amet commodi. Itaque nisi veritatis est culpa, accusamus aliquam maxime excepturi nulla quas unde exercitationem expedita laborum quaerat possimus hic. </p>
                                <div class="blog-post-featured-footer">
                                    <p class="blog-post-featured-author mb-0 me-3 ">Maxwell Iskiev</p>
                                    <span class="blog-post-featured-date">7/1/22</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="blog-post-category">
                            <div class="blog-post-category-header">
                                <h2>Featured Posts</h3>
                            </div>
                            <div class="blog-post-category-body">
                                <div class="blog-post-category-card">
                                    <div class="blog-post-category-title">
                                        <h3>
                                            <a href="">The Top Types of AI-Generated Content in Marketing [New Data, Examples & Tips]</a>
                                        </h3>
                                    </div>
                                    <div class="blog-post-category-footer">
                                        <span class="blog-post-category-auther">
                                            Tristen Taylor
                                        </span>
                                        <span class="blog-post-category-date">
                                            6/5/23
                                        </span>
                                    </div>

                                </div>
                                <div class="blog-post-category-card">
                                    <div class="blog-post-category-title">
                                        <h3>
                                            <a href="">How to Create a Sales Plan: Template + Examples</a>
                                        </h3>
                                    </div>
                                    <div class="blog-post-category-footer">
                                        <span class="blog-post-category-auther">
                                        Meredith Hart
                                        </span>
                                        <span class="blog-post-category-date">
                                        9/15/22
                                        </span>
                                    </div>

                                </div>
                                <div class="blog-post-category-card">
                                    <div class="blog-post-category-title">
                                        <h3>
                                            <a href="">5 Steps to Create an Outstanding Marketing Plan [Free Templates]</a>
                                        </h3>
                                    </div>
                                    <div class="blog-post-category-footer">
                                        <span class="blog-post-category-auther">
                                        Rebecca Riserbato
                                        </span>
                                        <span class="blog-post-category-date">
                                        8/25/22
                                        </span>
                                    </div>

                                </div>
                                <div class="blog-post-category-card">
                                    <div class="blog-post-category-title">
                                        <h3>
                                            <a href="">How to Create an Effective Customer Journey Map [Examples + Template]</a>
                                        </h3>
                                    </div>
                                    <div class="blog-post-category-footer">
                                        <span class="blog-post-category-auther">
                                        Aaron Agius
                                        </span>
                                        <span class="blog-post-category-date">
                                        5/4/23
                                        </span>
                                    </div>

                                </div>
                                <div class="blog-post-category-card">
                                    <div class="blog-post-category-title">
                                        <h3>
                                            <a href="">AI Web Design: Everything You Need to Know</a>
                                        </h3>
                                    </div>
                                    <div class="blog-post-category-footer">
                                        <span class="blog-post-category-auther">
                                        Madison Zoey Vettorino
                                        </span>
                                        <span class="blog-post-category-date">
                                        5/30/23
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 blog-post-items-header">
                        <h2 class="blog-post-items-title">Sales</h2>
                        <a href="" class="blog-post-items-seemore">See more sales articles</a>
                    </div>
                    <div class="col-lg-6">
                        <div class="blog-post-category-card  with-thumb">
                            <div class="blog-post-category-thumb">
                                <img src="https://blog.hubspot.com/hs-fs/hubfs/sales-efficiency.webp?noresize&width=100&height=134&name=sales-efficiency.webp" alt="">
                            </div>
                            <div class="blog-post-category-body">
                                <div class="blog-post-category-title">
                                    <h3>
                                        <a href="">6 Ways to Improve Sales Efficiency</a>
                                    </h3>
                                </div>
                                <p class="blog-post-category-desc">
                                Sales efficiency is one of the most important metrics for businesses to understand, track</p>
                                <div class="blog-post-category-footer">
                                    <span class="blog-post-category-auther">
                                        Tristen Taylor
                                    </span>
                                    <span class="blog-post-category-date">
                                        6/5/23
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="blog-post-category-card  with-thumb">
                            <div class="blog-post-category-thumb">
                                <img src="https://blog.hubspot.com/hs-fs/hubfs/ai-challenges.webp?noresize&width=100&height=134&name=ai-challenges.webp" alt="">
                            </div>
                            <div class="blog-post-category-body">
                                <div class="blog-post-category-title">
                                    <h3>
                                        <a href="">Concerns Salespeople Have About AI & How Leadership Can Address Them [New Data </a>
                                    </h3>
                                </div>
                                <p class="blog-post-category-desc">
                                Discover the main challenges AI can solve for sales reps, how to integrate it into your but </p>
                                <div class="blog-post-category-footer">
                                    <span class="blog-post-category-auther">
                                        Tristen Taylor
                                    </span>
                                    <span class="blog-post-category-date">
                                        6/5/23
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="blog-post-category-card  with-thumb">
                            <div class="blog-post-category-thumb">
                                <img src="https://blog.hubspot.com/hs-fs/hubfs/ai-enablement.webp?noresize&width=100&height=134&name=ai-enablement.webp" alt="">
                            </div>
                            <div class="blog-post-category-body">
                                <div class="blog-post-category-title">
                                    <h3>
                                        <a href="">Top Sales Challenges & How AI Can Power Your Sales Enablement Strategy</a>
                                    </h3>
                                </div>
                                <p class="blog-post-category-desc">
                                With sales teams now facing slimmer budgets and higher competition, sales enablement is vi</p>
                                <div class="blog-post-category-footer">
                                    <span class="blog-post-category-auther">
                                        Tristen Taylor
                                    </span>
                                    <span class="blog-post-category-date">
                                        6/5/23
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="blog-post-category-card  with-thumb">
                            <div class="blog-post-category-thumb">
                                <img src="https://blog.hubspot.com/hs-fs/hubfs/LinkedIn%20Request%20Fails.jpg?noresize&width=100&height=134&name=LinkedIn%20Request%20Fails.jpg" alt="">
                            </div>
                            <div class="blog-post-category-body">
                                <div class="blog-post-category-title">
                                    <h3>
                                        <a href="">8 Common Types of LinkedIn Request Lines That Flat-Out Don't Work (& What to Say</a>
                                    </h3>
                                </div>
                                <p class="blog-post-category-desc">
                                If you want your invites to make it all the way to your prospects’ inboxes, never use thes</p>
                                <div class="blog-post-category-footer">
                                    <span class="blog-post-category-auther">
                                        Tristen Taylor
                                    </span>
                                    <span class="blog-post-category-date">
                                        6/5/23
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <a href="" class="blog-post-items-seemore seemore-mobile">See more sales articles</a>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('js')
@endsection
