import React from "react";
import { Link } from "react-router-dom";
import video1 from "../assets/video2.mp4";

// Swiper imports
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, EffectFade } from "swiper/modules";
import "swiper/css";
import "swiper/css/effect-fade";

// Import global style.css
import "../style.css";

function Home() {
  return (
    <>
      <section id="home" className="hero">
        <video autoPlay muted loop className="hero-video">
          <source src={video1} type="video/mp4" />
       
        </video>

        <div className="hero-content">
          {/*  Only the Welcome heading will slide */}
          <Swiper
            modules={[Autoplay, EffectFade]}
            autoplay={{ delay: 3000, disableOnInteraction: false }}
            loop
            effect="fade"
            allowTouchMove={false}
            className="hero-swiper"
          >
            <SwiperSlide>
              <h1 className="sliderH1">
                Welcome to <span className="highlight">CodeZap</span>
              </h1>
            </SwiperSlide>

         </Swiper>

          {/*  These stay static (not sliding) */}
          <p className="sliderP">
            Kickstart your coding journey with beginner-friendly courses for all
            major programming languages!
          </p>

          

        </div>
      </section>

      {/* Tech Section */}
      <section className="tech-section">
         <h3 className="sliderH3"></h3>
        ONE STEP AHEAD <span className="highlight">IN TECHNOLOGY</span> 
        <p>
          Channeling the power of advanced technology blended with a dash of
          innovative spirit,CodeZap embodies the principle of unity, firmly
          professing "We Can" over "I Can."
        </p>
        <p>
          We specialize in a broad spectrum of educational services, including
          interactive coding courses, video tutorials, and community-driven
          
        </p>
        <p>
          Recognizing the dynamic nature of today's digital learning landscape,
          we constantly stay updated with the latest trends in education
          technology. This has allowed CodeZap to consistently exceed its
          goals.
        </p>
        <div className="icons">
          <span role="img" aria-label="code">💻</span>
          <span role="img" aria-label="video">🎥</span>
          <span role="img" aria-label="community">👥</span>
        </div>
      </section>
    </>
  );
}

export default Home;
