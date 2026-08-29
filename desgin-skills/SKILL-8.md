---
name: ai-ui-ux-design
version: "1.0"
description: >-
  A comprehensive AI skill for designing, evaluating, and improving web and
  application user interfaces and user experiences. It provides operational
  guidance for UX reasoning, information architecture, layout, visual
  hierarchy, typography, color, UI components, interaction patterns, motion,
  responsive design, dashboards and data visualization, SaaS and landing pages,
  AI interfaces, design systems, accessibility and usability, design critique,
  and design decision-making. The skill emphasizes user intent, purposeful
  design choices, technical design guidance, anti-patterns, contextual
  exceptions, and evidence-based visual references derived from the supplied
  design knowledge corpus.
---

# AI UI/UX Design Skill

> **Purpose:** This skill consolidates the design principles, heuristics, technical guidance, anti-patterns, workflows, patterns, and examples contained in the supplied design-video corpus. It is written as operational knowledge for an AI client: reason about the problem first, choose an appropriate design response, explain the trade-off, and validate the result.
>
> **Source discipline:** The guidance below is derived from the supplied captions. It does not silently replace source-specific advice with outside standards. Where the captions contain an apparently corrupted numerical transcription, the uncertainty is preserved rather than invented away.

## 0. Design Operating Principles

### 0.1 Design is problem solving, not decoration

- Design for the **end user**, not merely for the person commissioning the design.
- A visually attractive interface that does not help users accomplish the task is still a weak design.
- Start with the user's problem, goals, behavior, constraints, and context before deciding on visual treatment.
- A client's request is often only the surface-level description of the problem. Investigate what actually prevents users or the business from succeeding.
- Think more like a problem solver than a stylist. UI is the visual expression; UX is the reasoning behind structure, flow, and behavior.
- Good UI and useful functionality should coexist. Do not treat usability and aesthetics as mutually exclusive.
- Every important design choice should have an identifiable purpose. Avoid adding elements merely because a modern interface commonly contains them.

### 0.2 Let content and user intent drive form

- Choose a layout based on what the content is trying to accomplish.
- Do not start from a fashionable component and force content into it.
- If content is time-based, consider whether a timeline is more natural than a time-sorted table.
- If a section communicates a profound statement, a large centered typographic treatment with generous space may be appropriate.
- If a section communicates many related features, use a structure that lets the user see and compare the information rather than hiding features below the fold.
- Let the data determine the shape of data interfaces instead of decorating a predefined layout.

### 0.3 Simplicity and restraint

- Less is often more, but do not remove information that users genuinely need.
- Remove unnecessary cards, separators, redundant actions, decorative elements, and repeated information when they do not improve comprehension.
- Extra containers consume visual space and can make a UI feel more cluttered even when the amount of information is small.
- Use proximity and whitespace as structural tools; related things can be grouped by closeness instead of always being placed inside boxes.
- Simple does not mean empty. A good simple design has deliberate hierarchy and useful structure.

### 0.4 Variety without chaos

- A website can follow correct principles and still feel boring.
- Variation in layout, image treatment, sizes, spacing, color, depth, and interaction can create personality.
- Do not repeat the same image-left/text-right structure throughout an entire site.
- Introduce full-width sections, multi-column sections, stacked sections, cards, asymmetry, overlap, and other appropriate structural changes to create rhythm.
- Captivating design guides attention intentionally; chaotic design makes too many elements compete simultaneously.
- Surprise should be purposeful. Novelty should not reduce usability.

### 0.5 Design through iteration

- The first design is not required to be perfect.
- Use low-fidelity work to explore rapidly before committing to visual detail.
- Test assumptions early.
- Copying an existing high-quality interface as a study exercise can reveal spacing, component, hierarchy, and layout decisions more effectively than merely redesigning it.
- After several such exercises, recurring design patterns become easier to recognize.
- When improving a design, identify the highest-impact problems first rather than polishing everything indiscriminately.

## 1. User Intent, Problem Definition & UX Reasoning

### 1.1 Define the real problem

- Write a clear, concise problem statement before designing the solution.
- A wrong or nonexistent problem makes an otherwise polished solution irrelevant.
- Distinguish the requested deliverable from the underlying problem. A request for a website may actually be a request to improve navigation, discovery, conversion, organization, trust, or task completion.
- Focus on the user's actual behavior and pain points.

### 1.2 Research and evidence

- Personas and problem statements should be supported by research or evidence rather than invented details.
- Affinity mapping can consolidate observations into recurring findings and help form the problem statement.
- Simple data collection can still be useful when sophisticated research is unavailable, but recognize weaknesses in small or non-representative samples.
- UX testing can expose whether a wireframe or interaction is intuitive.
- Test, observe, modify, and test again.

### 1.3 Personas

- A persona is useful when it consolidates evidence and informs design decisions.
- Prioritize goals, frustrations, behavior, interests, and pain points relevant to the product problem.
- Avoid spending excessive effort on decorative persona details that do not influence design decisions.
- The persona should remain closely connected to the problem and proposed solution.

### 1.4 User flows

- Map the user's path through a task before producing the final interface.
- Keep flows focused. A large project is not required for a useful case study or useful flow.
- Different shapes or colors can distinguish decisions, processes, inputs, and outputs, but the system should remain easy to understand.
- Prefer clarity over visual complexity in flow diagrams.

### 1.5 Low-fidelity wireframes

- Use low-fidelity wireframes to ideate rapidly and compare layouts before investing in high-fidelity styling.
- Incomplete sketches can communicate process and reasoning; they do not need to look finished.
- Low-fi prototypes are useful for testing assumptions without committing to a full implementation.
- A practical workflow is: sketch → test with people → observe confusion → adjust → test again.

## 2. Information Architecture, Hierarchy & Progressive Disclosure

### 2.1 Visual hierarchy

Use multiple signals to establish priority:

1. Size
2. Font weight
3. Color/contrast
4. Position
5. Spacing
6. Density
7. Visibility

- Do not rely exclusively on larger text to create hierarchy.
- You should be able to describe the priority order of the interface's information before choosing its final visual treatments.
- Not every heading needs to be bold and full-opacity. Hierarchy should be designed as a system, not applied mechanically.
- Avoid excessive variations in weight, color, and size; too much differentiation becomes noise.

### 2.2 Primary and secondary actions

- A major section should normally have one visually dominant primary call to action.
- When two nearby buttons receive equal emphasis, users may not know which action is primary.
- Remove a redundant secondary button when possible.
- When a secondary button is required, reduce its visual prominence through treatment such as no fill, border, or lower-opacity styling.
- In destructive confirmation contexts, the destructive action may be primary and should receive the strongest appropriate semantic treatment; the cancel action should not compete visually.

### 2.3 Progressive disclosure

- Not everything must be visible at all times.
- Frequently used, high-importance functionality should be easy to see.
- Secondary or infrequent functionality can be revealed contextually through hover, popovers, menus, tooltips, or similar mechanisms.
- Progressive disclosure is not the same as hiding functionality. It is sequencing visibility so the user is not overwhelmed.
- Consider an explicitness spectrum: always-visible actions are highly explicit; contextual or hover-revealed actions are less explicit.
- Use the level of explicitness appropriate to task importance and frequency.

### 2.4 Onboarding

- Do not immediately expose a new user to every feature of a complex product.
- Introduce the most important action first, then progressively reveal the next relevant capability.
- A focused tooltip or short contextual prompt can be preferable to a large information-heavy introductory modal.
- Onboarding should teach through the product's actual flow.

## 3. Layout, Composition & Spatial Rhythm

### 3.1 Spacing and proximity

- Space can communicate relationships without containers.
- Close objects are perceived as related; greater separation communicates distinction.
- When several cards or rectangles intentionally sit close together, spacing precision becomes especially important.
- Avoid both accidental gaps and accidental collisions.
- Preserve enough breathing room that important content does not become visually cramped.

### 3.2 Grids

- Use grids to establish predictable structure, especially in dense product interfaces.
- Bento grids are flexible: the size and arrangement of boxes may need to change as the content plan becomes clearer.
- Do not design the grid independently of content.
- Bento layouts are compact and therefore require enough content to fill them meaningfully.
- Desktop product interfaces tend to require stricter grids than landing pages because more of the viewport is occupied by information.

### 3.3 Breaking the box

- Overlap can create movement and visual interest.
- Elements may extend beyond their nominal frame or overlap containers to break rigid row-and-column repetition.
- Begin with small changes such as shifting cards vertically rather than immediately creating a highly experimental composition.
- Use overlap intentionally; accidental overlap produces instability rather than personality.

### 3.4 Full-screen and stacked structures

- Full-screen sections can provide strong rhythm between more conventional sections.
- A two-column horizontal feature layout can sometimes become a one-column vertical sequence to focus the user's attention on one feature at a time.
- A thin image strip can work as an interlude or spacer between text-heavy sections.
- Large text followed by smaller navigation and a large visual can create a deliberate hierarchy because the surrounding elements reinforce the importance of the headline.

### 3.5 White space

- White space should be intentional, not automatically maximized.
- Excessive isolated space can make a page feel disconnected.
- If related content is pushed too far apart, bringing it closer can strengthen hierarchy and cohesion.
- A text-only section can deliberately use open space, but ensure enough supporting text exists to prevent the section from feeling accidentally empty.
- One source-specific heuristic: body copy in a spacious text-heavy section generally benefits from roughly three or more lines so the area does not feel disproportionately empty.

## 4. Typography System

### 4.1 Typeface categories

- Serif fonts contain serifs and can communicate a more traditional or authoritative character.
- Sans-serif fonts are cleaner and common in contemporary interfaces.
- Display fonts are suitable for large text because their ornamentation and detail may not scale well to paragraph sizes.
- Handwritten fonts can function as display-oriented accents.
- Never use a display or handwritten typeface for small paragraph text when it reduces readability.

### 4.2 Font pairing

- One font can be sufficient for a complete interface.
- Two fonts are usually enough for a modern system.
- Three fonts can work when each has a clear role, such as display + sans-serif + detail/caption serif.
- Four distinct fonts should be treated as a warning sign unless there is a compelling system-level reason.
- Common pairings include display + sans-serif or serif + sans-serif.

### 4.3 Typography anatomy and spacing

- Baseline: the line from which letters rise or descend.
- X-height: the lower-height reference for lowercase characters.
- Cap height: the height of capital letters.
- Letter spacing should respond to text size; larger text generally requires proportionately less spacing and smaller text proportionately more.

### 4.4 Weight and color as hierarchy

- Size, weight, and color can work together to create hierarchy.
- The source recommends using at most about two font weights in a typical interface.
- When choosing two weights from a family with many weights, separate them enough to create visible differentiation rather than choosing adjacent near-identical weights.
- For ordinary text, avoid extreme ultra-bold and ultra-thin weights unless they are deliberately required by the visual system.
- A common source-specific approach is to use a primary text color plus a reduced-opacity variant.
- The source gives a reduced text-opacity range of roughly **45–70%** in one hierarchy example.
- A separate typography discussion cites roughly **40–70%** as a useful range for reduced text color; use these as practical ranges rather than as immutable laws.

### 4.5 Fluid type scales

The source explores the Golden Ratio as a way to construct a type scale:

- Golden Ratio ≈ **1.62**.
- A base size can be multiplied by 1.62 to obtain a larger step.
- Because a full 1.62 scale can grow too quickly across multiple heading levels, the source proposes using the square root of the Golden Ratio, approximately **1.27**, for a gentler scale.
- If even smaller progression is needed, the cube root of the Golden Ratio can be used.
- Smaller ratios can be useful for dashboards with many text styles or for constrained mobile interfaces.
- The important principle is to establish a coherent mathematical or systematic relationship between levels instead of choosing every font size independently by eye.

### 4.6 Responsive typography

- Avoid treating desktop and mobile font sizes as unrelated manual decisions when fluid scaling is appropriate.
- The source proposes a fluid relationship based on the smallest and largest expected sizes and a ratio derived from the current viewport width.
- The referenced example uses **1920px** as a large width and **320px** as a small width.
- If the interpolation should not exceed intended limits, clamp the result with minimum and maximum boundaries.
- A fluid type system can reduce the need for multiple breakpoint-specific font sizes.

### 4.7 Line height

- Smaller text and longer line widths generally benefit from increased line height for readability.
- Larger display text generally benefits from tighter line height.
- Source heuristic: paragraph text around **150%** line height.
- Source heuristic: headings around **110–130%** line height.
- Do not depend blindly on automatic line height, especially for extremely large display text.

### 4.8 Large display text

- Treat typography as a visual asset, not only as explanatory content.
- Large display text can become a primary visual element when the brand and content support it.
- Do not overuse giant text. The source recommends roughly once or twice per page as a general ceiling.

## 5. Color System & Color Theory

### 5.1 Color restraint

- Use fewer colors deliberately.
- Do not make every card or component a different color merely because color is available.
- Strong saturation can quickly become visually exhausting and may harm clarity.
- Muted colors can create sophistication and cohesion.
- Useful examples include soft blues, beige, lavender, off-whites, and bluish blacks.

### 5.2 Neutral foundations

- A product interface can be built primarily from neutral layers and use color selectively for function.
- The source describes product palettes using multiple background levels, one or more stroke treatments, and several text variants.
- A darker frame or sidebar can act as a visual anchor.
- On light interfaces, cards may be darker than the background or the background may be subtly darker than cards.
- Pure white can be reserved for surfaces when the background itself is slightly off-white, helping the surface remain distinguishable.

### 5.3 Contrast and edges

- Do not use a border simply because a card needs separation.
- When subtle separation is needed on a light interface, the source recommends a light edge rather than an aggressive black border.
- Contrast should support comprehension and state recognition rather than simply make the design louder.
- The source explicitly warns that many overly colorful cards can fail practical contrast checks.

### 5.4 Functional color

- In product interfaces, color should communicate function, state, or importance rather than being sprinkled around as decoration.
- Build functional colors as scales rather than thinking of an accent as a single isolated color.
- A mid-scale value can act as the primary color while darker/lighter steps support states such as hover or links.
- Source example: a primary functional color around a 500/600 step, with a darker 700 hover treatment and lighter 400/500 link treatment.

### 5.5 Button hierarchy through color

- Stronger button importance can be expressed through stronger/darker visual weight.
- Primary actions should have stronger contrast than secondary actions.
- Ghost and secondary actions should not visually compete with the primary action.

### 5.6 Dark mode

- Dark mode is not simply a background swap.
- Light text must be recalibrated for the dark surface.
- Highly saturated brand colors often need to be lightened or otherwise adjusted for dark mode.
- Surface layering can produce depth: a darker structural background behind lighter cards can create visual separation.
- Frosted/glass-like treatment can be used when it reinforces hierarchy and depth, but it should not become decoration without purpose.

### 5.7 60-30-10 versus product systems

- The 60-30-10 concept can be useful as a simple starting model: roughly 60% dominant neutral, 30% secondary color, and 10% accent.
- Do not apply it rigidly to product UIs where many semantic states and neutral layers are required.
- Product interfaces may need several neutral surfaces, text levels, strokes, interactive states, and chart colors.

## 6. Icons, Imagery & Visual Assets

### 6.1 Icons

- Use a consistent icon style within the same interface.
- Mixing unrelated icon styles is an easy way to make a UI feel inconsistent.
- Icons should generally be simple rather than excessively detailed.
- Larger icons can carry more detail; smaller icons should usually be simpler.
- Prefer coherent icon packs or libraries when consistency matters.
- Source reference: Feather Icons is cited as a useful minimal icon library.

### 6.2 Images

- Image selection is part of interface design, not merely asset collection.
- Choose source images that can survive the intended crop and aspect ratio.
- For large hero imagery, use sufficiently high-resolution assets to avoid pixelation.
- If an important subject is too large in the source image, use a more zoomed-out asset before placing it full-screen.
- Consider what will be cropped at every breakpoint.
- Do not place essential content in a region likely to be cut off.
- For product imagery, cropping and zooming into a portion of the image can create a strong visual treatment.
- Landscape imagery can support text overlays for brand messaging.
- Masking imagery into shapes that match the site's visual identity can make layouts feel less generic.

### 6.3 Texture

- Noise can add texture and help text contrast against an image or colored background.
- Texture should reinforce the brand and visual identity instead of being added as a generic effect.
- Visual identities can be built from image mood, extracted color, typography, icons, texture, and composition rather than from a rigid formula.

## 7. Buttons, Controls & Component Hierarchy

### 7.1 Buttons

- Not every button needs a filled background.
- Filled primary actions should have clear visual precedence.
- Secondary controls can use borders, text-only treatment, or reduced emphasis.
- Primary and secondary controls placed next to each other should not accidentally look equally important.
- Buttons should generally have a small interaction response so users can perceive that the control is interactive.

### 7.2 Signifiers and affordances

- The interface should communicate what can be interacted with without requiring excessive instructions.
- Use visual signifiers such as selected states, active navigation, hover states, button states, and tooltips.
- A selected item should look different from a merely grouped item.
- Disabled or inactive content should communicate its state clearly.
- Users should be able to infer likely behavior from visual treatment.

### 7.3 Cards

- Cards are useful for grouping related content but consume significant visual space.
- In dense interfaces, excessive card usage can create clutter.
- Consider whether spacing alone can communicate grouping before wrapping information inside a card.
- Dashboards commonly use many cards, so maintain margins and spacing to prevent the page from feeling tightly packed.
- Borders and background surfaces can both define cards; choose based on theme, density, and contrast needs.

## 8. Navigation, Sidebars, Tabs, Modals, Popovers & Toasts

### 8.1 Navigation

- Navigation should have hierarchy; not every link should look equally important.
- Important actions can receive stronger emphasis.
- Avoid menus that are visually flat or disproportionately weighted to one side.
- When navigation grows, use menus, dropdowns, mega menus, or progressive disclosure rather than allowing the header to become unusable.
- A large, useful mega menu can communicate product depth while keeping the primary navigation manageable.

### 8.2 Sidebars

- Sidebars are especially useful for product navigation and persistent controls.
- A basic product sidebar can place the logo at the top, main navigation nearby, team or workspace context in a logical position, and settings toward the bottom.
- Controls for creating widgets or sections can be moved into the sidebar when their original placement creates hierarchy problems.
- Collapsed sidebars should preserve recognizable icons and important destinations.

### 8.3 Tabs

- Tabs are useful when related views need to remain within the same context.
- They can provide the equivalent of multiple sub-pages without making the global sidebar larger.
- Use tabs for genuinely related contexts; do not use them to hide unrelated functionality.

### 8.4 Popovers

Use a popover when:

- The context is relatively simple.
- The action is non-blocking.
- The user can click away without consequences.

Use popovers to progressively reveal secondary functionality without navigating away from the current context.

### 8.5 Modals

Use a modal when:

- The context is more complex.
- The task should remain tied to the current page.
- The user needs to explicitly complete or cancel the action before returning to the underlying context.

Because modals are blocking, keep their purpose clear and avoid using them for information that could be handled non-blockingly.

### 8.6 Toasts

- Toasts are lightweight notification surfaces.
- Use them when the user needs awareness but does not need to stop what they are doing.
- They are useful for confirmation, warnings, and errors.
- After a blocking modal changes something, a toast can confirm the result once the modal closes.

### 8.7 New pages

- If the context is large or permanent, a dedicated page can be more appropriate than a modal.
- When navigating to a new page, provide a clear way back, such as a back button or breadcrumb when appropriate.

## 9. Dashboard & Product UI Design

### 9.1 Dashboards are information systems

- Dashboards should be built around the data and tasks they need to expose.
- The main section should reflect what matters most to the user.
- Do not fill the dashboard with every metric merely because the data exists.
- Keep the dashboard focused enough that the user understands its purpose quickly.

### 9.2 Dashboard density

- Product dashboards are usually denser than marketing pages.
- Typography is generally smaller and the spacing between type levels is tighter.
- Grid discipline is stronger because much of the available viewport is used for information.
- Avoid creating a dashboard that looks as though every available component was placed on the screen.

### 9.3 Rank modules by importance

A practical approach from the source:

1. Identify the user's most important recurring actions or information.
2. Rank modules by importance.
3. Place high-priority content in strong visual positions, especially toward the upper/left regions in conventional LTR layouts.
4. Use lower-priority areas for secondary analytics or less frequently accessed information.
5. Re-rank as the full set of modules becomes clear.

### 9.4 Tables

- Tables should communicate structured data efficiently.
- Separation can come from spacing, dividers, or color.
- A table is more than a visual arrangement of data: useful tables support search, filtering, and sorting when the dataset requires them.
- Right-align numerical values when place-value alignment improves comparison.
- Convert bounded categorical values into chips or other compact visual representations when that improves scanning.
- Truncate very long text when full display would consume too much space, while retaining a way to inspect the complete value where necessary.
- Visually distinguish inactive/deactivated rows when the state matters.
- Do not use a table automatically. If the data is inherently sequential or time-based, a timeline or another structure may be easier to follow.

### 9.5 Data-driven color

- Color in a dashboard should normally have semantic purpose.
- Urgent activity can use a strong warning color to draw attention.
- Avatars can help users associate actions with people faster than names alone.
- Use color to help identify status, urgency, categories, or changes rather than to decorate unrelated modules.

### 9.6 Charts

- Avoid ambiguous or decorative chart shapes that do not communicate a recognizable data relationship.
- Use familiar visualizations when they fit the data.
- Basic line and bar charts can be both attractive and informative.
- Include grid lines, scale numbers, time ranges, and summaries when needed for interpretation.
- Use labels and context so numbers do not become meaningless decoration.
- Choose the chart based on the nature of the data.
- Use icons or identifiers when multiple data series need fast recognition.
- Consider comparison controls when users may need to compare portfolios, periods, categories, or other series.
- A full-screen chart view can be useful when the compact dashboard chart cannot provide enough detail.

### 9.7 Optimistic UI

- For quick operations where success is highly expected, the interface can respond immediately rather than waiting for a server response.
- Example from the source: an item disappearing immediately after deletion communicates responsiveness while the request is completed in the background.
- Use optimistic interaction when the design can safely handle the possibility of failure and communicate errors afterward.

## 10. Landing Pages & Marketing Interfaces

### 10.1 The landing page has different constraints from a dashboard

- Landing pages can use larger type, stronger imagery, more whitespace, and more visual experimentation.
- Product dashboards prioritize information density, repeatability, task efficiency, and clarity.
- Do not copy dashboard density into a marketing page or marketing-page novelty into a workflow-heavy product UI without reason.

### 10.2 Hero sections

Possible structures include:

- Text left + image right.
- Text + full-width image.
- Text centered above a large visual.
- Large text above smaller navigation and a large image/video.
- In uncommon cases, text below imagery.

Select the structure based on the role of the content.

### 10.3 Landing-page progression

The source describes a maturity progression:

- **Low maturity:** technically functional but template-like, repetitive, generic imagery, weak hierarchy, flat navigation, little intentional color or motion.
- **Developing:** better visual identity, stronger headline, real product imagery, improved hierarchy, clearer CTA consistency, basic motion, and better page flow.
- **Advanced:** deliberate product framing, curated imagery, stronger interactive sections, richer navigation, concise copy, social proof, and subtle interaction.
- **Highly refined:** attention to detail across motion, typography, visual balance, copy, composition, imagery, transitions, and brand expression. The difference between good and great is often accumulated detail rather than one dramatic feature.

### 10.4 Copy hierarchy

- Headlines should be concise and punchy when visuals carry part of the narrative.
- Avoid long blocks of text that users are unlikely to read.
- Move from describing merely **what the product does** toward communicating **how the product helps** when the objective is stronger value communication.
- Use visuals as part of the narrative rather than repeating information that the visual already communicates.

### 10.5 SaaS landing-page trust

- Presentation quality influences perceived credibility.
- Real product visuals usually communicate more relevance than generic stock imagery.
- Avoid repetitive template-like sections.
- Social proof, logos, testimonials, strong product imagery, and coherent visual identity can reinforce trust when genuinely relevant.
- Landing pages are not improved by complexity for its own sake; presentation quality and message clarity matter more.

## 11. Distinctive Visual Identity & Brand Translation

### 11.1 Start from the feeling

- A strong visual identity does not have to come from a rigid formula.
- Determine what the brand should feel like and choose imagery, colors, typography, icons, textures, and composition that support that feeling.
- The visual identity should relate to the audience and product rather than merely following generic "modern" conventions.

### 11.2 Build an identity from references

A practical method demonstrated in the source:

1. Select a small set of images with the desired mood.
2. Crop and treat them consistently.
3. Pull recurring tones from those images to establish a base palette.
4. Add deliberate accent colors.
5. Choose typography that reinforces the brand character.
6. Introduce icons representing important product concepts.
7. Add texture or environmental imagery where it supports the identity.
8. Apply the identity consistently across the layout.

### 11.3 Frankensteining for structure

- Use references from several strong websites to construct a structural prototype.
- Borrow a hero approach from one product, a logo ribbon structure from another, a feature presentation from another, a testimonial treatment from another, etc.
- The goal is not to copy final visual output. Use references to discover effective information architecture and flow.
- After extracting the wireframe, replace the borrowed visual identity with the product's own brand system.

## 12. Motion, Animation & Micro-interactions

### 12.1 Motion should have a job

- Animation should add clarity, feedback, continuity, functionality, or intentional character.
- Do not animate elements simply because animation is available.
- Avoid motion that slows the experience, distracts from the task, or makes basic actions harder to use.

### 12.2 Appropriate uses

Useful patterns from the source include:

- Small button hover/press responses.
- Image zoom on hover.
- Subtle dashboard hover effects.
- Staggered entrance of grouped elements.
- Expanding navigation.
- Contextual accordions.
- Card stacking/reveals.
- Section transitions that visually connect one area to another.
- Marquee text when its usability impact is acceptable.
- Loading animations that communicate progress without dominating the experience.

### 12.3 Loading animations

- Loading states should feel short, fluid, and visually coherent with the product.
- Avoid overly elaborate loaders that increase perceived waiting time.
- Motion can be used to make an experience feel more polished, but speed and clarity take priority.

### 12.4 Scroll and transition design

- Scroll-triggered motion can create continuity between sections.
- Use scroll effects sparingly when they affect the user's ability to navigate or scan.
- A transition can be designed around the focal point: as the user leaves one section, move its elements out of the focal area while introducing the next section in a controlled way.
- Avoid scroll-jacking effects unless there is a compelling reason and the usability cost is justified.

### 12.5 Reduced usability warning

- Some trendy interactions can make interfaces less usable.
- Always judge motion against comprehension, control, performance, and task completion.

## 13. Depth, Shadows, Gradients & Surface Effects

### 13.1 Shadows

- Shadows should communicate depth, not merely decorate components.
- If a shadow does not improve the design, remove it.
- Source strategy: X offset should be less than or equal to Y offset.
- Source gives a blur relationship of approximately **1.3× to [uncertain transcription]× the Y value**. Because the supplied caption appears corrupted at this point, do not treat the upper multiplier as verified.
- Source also suggests reducing a typical Figma shadow opacity from 25% to approximately **15–20%**, depending on the background.
- Darker backgrounds may require a stronger shadow to remain visible.

### 13.2 Gradients

- Gradients can easily reduce clarity when used without purpose.
- Experiment with them, but evaluate the result critically.
- If a gradient is making the design weaker, remove it rather than preserving it because it looks trendy.

### 13.3 Layered depth

- Offset buttons, layered backgrounds, darker frames behind lighter cards, and controlled surface differences can create depth without heavy effects.
- Depth should reinforce spatial hierarchy.

## 14. Responsive & Device-Specific Design

### 14.1 Design on the intended screen

- View the design at the screen size and context for which it is intended.
- Designing zoomed out in Figma can cause fonts and spacing to become unnecessarily large.
- Preview prototypes on desktop and on mobile rather than assuming the Figma canvas represents the final experience.
- Browser chrome consumes viewport space, so account for it when evaluating height-dependent compositions.

### 14.2 Responsive composition

- Do not merely scale a desktop composition down.
- Reconsider the information hierarchy, layout structure, image crops, and interaction mechanisms for smaller screens.
- Fluid typography can reduce abrupt changes between devices.
- Large desktop compositions may need stacking or reordering on mobile.

## 15. Desktop-First Product Affordances & Native-Feeling Apps

- Users develop expectations from the platform they use.
- Interfaces can feel more trustworthy and comfortable when they respect familiar platform conventions.
- For desktop software, consider window hierarchy, sidebars, menus, keyboard-oriented interaction, hover behavior, context menus, and platform-like controls where the product context warrants them.
- Native-feeling does not mean blindly copying an operating system. Use familiar interaction conventions when they reduce learning effort.

## 16. Accessibility, Usability & Clarity

### 16.1 Contrast

- Color choices should remain usable when contrast is required for text, controls, and states.
- Do not rely on color alone to communicate critical state when another signifier is necessary.

### 16.2 Readability

- Paragraph line height, text size, contrast, and width must work together.
- Smaller text needs sufficient separation and contrast.
- Large display text must be checked at the intended viewing size, not judged only from a zoomed-out design file.

### 16.3 Interaction clarity

- Users should understand which controls are clickable, selected, inactive, dangerous, or secondary.
- Tooltips can explain affordances when an icon or unfamiliar control is not self-evident.
- Do not make primary functions dependent on tiny targets when larger or more direct interaction is available.

## 17. AI Interface Design

### 17.1 Prompt box as control center

- For prompt-based products, a large prompt/input area can reduce friction by getting the user into the core task immediately.
- The prompt box should feel useful rather than empty.
- Preview attached PDFs/images where useful.
- Compress large code inputs into readable blocks rather than letting raw code overwhelm the conversational interface.
- Context tags or chips can let users communicate mode or intent, such as brainstorming, data, or email.
- Allow contextual references to files, code, designs, or connected resources when they are relevant to the task.
- Progressive disclosure can expose advanced options without crowding the default state.
- If meaningful to the product, show token/cost information near the generation control.

### 17.2 Integrations

- As AI products become more capable, deep integrations can become part of the interaction model.
- Make connected tools discoverable without allowing integrations to overwhelm the primary task.
- Use familiar chips, buttons, or selectors for context attachment.

### 17.3 AI loading and generation feedback

- AI loading states should be short, fluid, and visually restrained.
- Small looping indicators can communicate that the system is active without dominating the interface.

### 17.4 Generation history

- If the product generates reusable outputs, history becomes a core workspace feature.
- The central design principle is **retrievability**.
- Preview enough of previous outputs for users to recognize them.
- Provide deletion controls.
- Provide search when history can become large.
- Keep generated items associated with their relevant session, document, or context.

### 17.5 Memory

- If an AI product has persistent memory, expose that concept to users and give them control.
- Users should be able to understand what is being remembered.
- Useful patterns include a dedicated memory panel, visible storage/contents, bulk deletion, and adding important facts to persistent memory.
- Do not silently treat persistent memory as invisible infrastructure when user control is part of the product experience.

### 17.6 Inline AI editing

- Let users select or highlight a specific piece of generated content and edit it in context when the task benefits from local changes.
- Contextual actions such as improving writing or fixing spelling can reduce friction.
- Keep contextual AI controls compact so they do not visually overwhelm the document.

## 18. Design Systems & Scalability

### 18.1 Design systems as shared language

- A design system is not merely an aesthetic library.
- It creates consistency, speed, predictability, and trust.
- Users learn repeated conventions: when controls, spacing, type styles, and colors behave consistently, new screens require less learning.
- A good system does not require hundreds of components. It requires decisions the team can apply consistently.

### 18.2 System architecture

Define reusable rules for:

- Colors.
- Typography.
- Spacing.
- Buttons.
- Inputs.
- Cards.
- Navigation.
- Interaction states.
- Common modal structures.
- Repeated layouts.

### 18.3 Scale the system to the organization

- A small product team may need a lightweight, flexible system that is easy to update.
- A large multi-product ecosystem may need more extensive and explicit rules.
- The system should reflect the team's actual use cases rather than copying a large framework without need.

### 18.4 Intentional rule breaking

- Consistency is not the same as making every screen identical.
- Know the system before deviating from it.
- Break a rule deliberately when doing so produces a meaningful product or brand benefit.

## 19. Design Critique & Redesign Framework

When auditing an existing interface, use this sequence:

### Step 1 — Identify the user's job

What does the user need to accomplish here?

### Step 2 — Identify the information

What information is necessary, optional, redundant, or missing?

### Step 3 — Rank importance

Which information/actions are primary, secondary, and tertiary?

### Step 4 — Check the representation

Does the chosen component match the underlying information?

Examples:

- Time-based data → consider a timeline.
- Comparable categories → table or grouped chart.
- Compact repeated information → card/list/grid.
- Related secondary actions → contextual menu/popover.

### Step 5 — Remove redundancy

Look for:

- Duplicate controls.
- Repeated information.
- Unnecessary charts.
- Decorative widgets with no task value.
- Overly large labels that merely restate obvious context.

### Step 6 — Correct hierarchy

Check:

- Size.
- Weight.
- Color.
- Contrast.
- Position.
- Spacing.
- Visibility.

### Step 7 — Check interaction

- Can users tell what is interactive?
- Are states visible?
- Are secondary actions appropriately disclosed?
- Are important controls easy to access?

### Step 8 — Check visual cohesion

- Typography system.
- Icon style.
- Corner radius.
- Color language.
- Surface treatment.
- Image treatment.
- Spacing rhythm.

### Step 9 — Check real-world usability

- Intended viewport.
- Scrolling behavior.
- Content overflow.
- Image crop.
- Long text.
- Empty states.
- Error states.
- Loading states.
- Hover/focus/pressed states.

### Step 10 — Validate

- Test the revised structure.
- Compare before/after.
- Keep improvements that increase comprehension or task success, not merely those that look more fashionable.

## 20. Common Anti-patterns

Avoid the following unless a strong contextual reason exists:

- Repeating identical section structures down an entire landing page.
- Using cards and dividers everywhere.
- Giving multiple nearby actions equal emphasis.
- Using large decorative typography so frequently that it loses its hierarchy.
- Mixing unrelated icon styles.
- Choosing images that cannot survive the intended crop.
- Using low-resolution imagery in large hero areas.
- Using display or handwritten fonts for small paragraph text.
- Creating tables when the data naturally wants another structure.
- Designing charts without labels or context.
- Adding color simply for decoration in functional product interfaces.
- Using shadows and gradients because the design feels empty rather than because they serve a purpose.
- Adding animation without a clear interaction or communication function.
- Making scroll interactions so elaborate that they reduce usability.
- Exposing every feature at once to new users.
- Hiding important actions behind obscure controls.
- Designing only on the Figma canvas without checking the intended viewport.
- Optimizing for visual novelty while ignoring the end user's task.
- Building generic AI/SaaS interfaces from interchangeable visual clichés without relating the design to the product or audience.

## 21. Website Section Pattern Library

These patterns are useful references, not mandatory templates.

### 21.1 Layered card section

- Rounded rectangles placed over a contrasting background.
- Works particularly well when cards are close together.
- Requires precise spacing and consistent corner treatment.
- Can act as a hero/header or repeat throughout a site.
- Source references include Huddle and Toa.

### 21.2 Image interlude with statement

- Thin or cropped image with a strong statement.
- Useful as a visual interlude between text-heavy sections.
- Add a gradient beneath text when necessary for readability.
- Choose imagery carefully because heavy cropping may be required.
- Source references include One Nil and Rinse FM.

### 21.3 Giant type + navigation + giant visual

- Large display text dominates the upper area.
- Small navigation creates contrast and reinforces headline importance.
- Large image/video supports the visual scale.
- Requires high-resolution visual assets and a suitable display face.
- Source references include Maa and Studio Vi.

### 21.4 Multi-image carousel/stack

- One large image with additional images accessible by scrolling or controls.
- Use progress indicators when the number of items or current position is important.
- Consider image orientation carefully because heavy crops may be required.
- Useful when displaying several related images without creating a long vertical gallery.

### 21.5 Sliding stacked cards

- Cards or sections slide to reveal the content beneath.
- Useful for presenting a short sequence of three to five options in detail.
- Can be driven by scroll or hover depending on context.
- Ensure the interaction remains discoverable.
- Source references include Huddle and Tapaku Maru.

### 21.6 Compact horizontal card scroller

- Useful for showing roughly 3–10 cards in a constrained space.
- Provide obvious controls or direct manipulation.
- More than roughly ten items may become cumbersome and may deserve another information structure.
- Source reference: Amie.

### 21.7 Bento grid

- Multiple content blocks arranged in a compact modular grid.
- Adapt box sizes to the content rather than preserving a rigid initial wireframe.
- Requires enough content to fill the compact structure.
- Source reference: Linear, with a modified full-width interpretation.

### 21.8 Image cutout typography

- Large uppercase text can act as a cutout within an image.
- The effect is visually strong but depends heavily on choosing an image whose subject and negative space survive the crop.
- Can be extended with additional text, navigation, or controls where appropriate.

### 21.9 Text-led open section

- Remove imagery intentionally and let typography carry the section.
- Use generous space, but include enough supporting text to prevent accidental emptiness.
- Useful when the message itself is the primary visual.

## 22. Reference Products & What to Study

The named products/websites in the corpus are valuable because the source repeatedly uses them as demonstrations of specific decisions. Treat these as **study references**, not universal authorities.

- **Apple:** product presentation, imagery, stacked feature layouts, crop/zoom treatments, large-scale visual storytelling, platform familiarity, progressive disclosure.
- **Linear:** restrained product UI, design-system consistency, Bento layouts, cohesive application structure.
- **Vercel:** neutral product UI, restrained color, dashboard structure, surface layering.
- **Notion:** contextual tabs/views, product navigation, settings structure, light neutral layers.
- **Shopify:** layout variation, section rhythm, visual depth, content restructuring.
- **Google / Chrome / Gemini:** AI product entry points, large prompt-first experiences, differing levels of marketing presentation.
- **OpenAI / ChatGPT:** prompt-first interaction, generation history, memory concepts, direct access to the product interface.
- **Claude:** attachment previews, loading animation style, contextual inline AI patterns.
- **Replit:** compact presentation of pasted code and code-oriented context handling.
- **Cursor:** context tagging and contextual code references.
- **Miro:** large visual tabs and content organization patterns.
- **Wise:** product-card treatments and large CTA references in the source.
- **Superpowered / Actual / Better Stack / Atio / Anchor / Mobbin:** reference examples for product identity, section composition, logos, testimonials, visuals, and research workflows.
- **Rivian:** automotive navigation and presentation reference.
- **Fisker / Arrival / Polestar / Lucid:** comparative examples for automotive landing-page hierarchy and information architecture.
- **Amie:** compact horizontal information browsing.
- **Feather Icons:** consistent minimal icon reference.

### Reference rule

When using a reference, ask:

1. What exact problem does this reference solve?
2. What structural pattern is being demonstrated?
3. Which parts can transfer to the current product?
4. Which parts are brand-specific and should not be copied?

## 23. Design Research & Reference-Browsing Method

- Study real products rather than relying only on abstract inspiration.
- Look at many examples of the same problem to identify recurring patterns.
- When stuck on a section, search specifically for that section type and compare multiple implementations.
- Copying an interface as a learning exercise can expose subtle decisions such as card spacing, navigation height, button padding, typography, and alignment.
- Build pattern recognition by studying multiple high-quality products rather than memorizing one design system.

## 24. AI Design Decision Protocol

When asked to design or redesign an interface, follow this reasoning order:

1. **Clarify the user's goal from the available context.**
2. **Identify the actual problem rather than treating the requested component as the problem.**
3. **Determine the information hierarchy.**
4. **Choose the information structure that matches the content.**
5. **Decide what must be immediately visible and what can be progressively disclosed.**
6. **Choose components based on function rather than trend.**
7. **Establish layout/grid and spacing before polishing decoration.**
8. **Create typography hierarchy with size, weight, and color working together.**
9. **Apply a restrained color system with semantic meaning.**
10. **Select imagery and icons that fit the intended crop, size, and visual language.**
11. **Define interaction states and signifiers.**
12. **Use motion only where it improves clarity, feedback, continuity, or intentional character.**
13. **Check the intended device and viewport.**
14. **Check content extremes: long names, many items, missing data, errors, empty states.**
15. **Remove redundant or decorative elements that do not earn their space.**
16. **Critique the result as a user, not only as a designer.**
17. **Validate the final structure against the original problem and intended outcome.**

## 25. Final Design Review Checklist

Before considering an interface complete, verify:

### Problem & UX

- [ ] The primary user goal is clear.
- [ ] The interface solves the actual problem rather than only satisfying the requested deliverable.
- [ ] The information architecture matches the user's task.
- [ ] Primary actions are obvious.
- [ ] Secondary actions do not compete unnecessarily.

### Layout

- [ ] The grid supports the content.
- [ ] Spacing communicates relationships.
- [ ] There is enough breathing room.
- [ ] Repetition has been balanced with meaningful variation.
- [ ] No element is isolated without purpose.

### Typography

- [ ] Font roles are consistent.
- [ ] Font count is controlled.
- [ ] Weight differences are meaningful.
- [ ] Text colors reinforce hierarchy.
- [ ] Line height is appropriate for the text size.
- [ ] Large typography has been checked at the intended viewport.
- [ ] Responsive scaling remains coherent.

### Color

- [ ] Color has a reason to exist.
- [ ] Accent colors are not overused.
- [ ] Muted colors are used where appropriate.
- [ ] Text/background contrast is usable.
- [ ] Light/dark surfaces remain distinguishable.
- [ ] Functional states have clear semantic treatment.

### Components

- [ ] Buttons communicate priority.
- [ ] Icons share a visual style.
- [ ] Cards are used when grouping adds value.
- [ ] Tables provide the controls needed for the dataset.
- [ ] Charts match the data.
- [ ] Modals/popovers/toasts are used according to context.
- [ ] States are visible and understandable.

### Motion

- [ ] Animation has a purpose.
- [ ] Interactions provide useful feedback.
- [ ] Motion does not obstruct the task.
- [ ] Scroll effects do not reduce control or usability.
- [ ] Loading states are fluid and restrained.

### Content & Assets

- [ ] Images survive their crop.
- [ ] Large visuals have adequate resolution.
- [ ] Long labels do not destroy the layout.
- [ ] Important content is not hidden or accidentally cut off.
- [ ] Empty/error/loading states have been considered.

### System & Consistency

- [ ] Repeated patterns behave consistently.
- [ ] Spacing and type scales are systematic.
- [ ] Colors are reusable and semantic.
- [ ] The interface feels like one product rather than unrelated screens.
- [ ] Any deliberate deviations from the system are intentional.

## 26. Professional Practice Notes Kept Separate from Core UI/UX

The source also contains portfolio, case-study, client, pricing, analytics, and career advice. Some of this overlaps directly with design practice and should be retained for a future companion **Professional Designer / Case Study / Freelance Business Skill**.

Core design-process concepts from those sections have already been incorporated above, including:

- problem definition,
- research evidence,
- affinity mapping,
- personas,
- user flows,
- low-fi wireframes,
- usability testing,
- explaining design decisions,
- reflection and iteration,
- concise case-study presentation,
- analytics as evidence of outcomes,
- focusing on UX outcomes rather than visual output alone.

Pricing mechanics and sales-specific material are intentionally outside this core UI/UX skill because they do not directly teach interface design. They should be preserved in the companion professional skill rather than discarded.

## 27. Source-Preservation Rules for This Skill

When this skill is expanded from additional source material:

- Preserve design-specific technical details even when they appear inside casual conversation.
- Preserve warnings and anti-patterns with the same importance as positive recommendations.
- Preserve numerical values, ranges, formulas, and specific implementation guidance when the source supports them.
- Preserve the reasoning behind a recommendation whenever the source provides it.
- Preserve context and exceptions rather than converting contextual advice into absolute laws.
- Preserve useful named references and explain what the reference demonstrates.
- Remove only content with no design, UX, product, or professional-design learning value, such as greetings, subscription requests, sponsorship copy, irrelevant personal commentary, and unrelated implementation chatter.
- Do not silently invent missing values or "correct" uncertain transcription without evidence.

## 28. Core Principle

> **Do not design from components outward. Design from the user's problem and the information outward.**
>
> First determine what the user needs to understand or accomplish. Then determine what information matters, how it should be structured, what should be visible, what can be disclosed progressively, which visual hierarchy communicates priority, which component best represents the information, and which visual treatment gives the product the right identity. Finally, validate the result on the intended device and against real-world content.
